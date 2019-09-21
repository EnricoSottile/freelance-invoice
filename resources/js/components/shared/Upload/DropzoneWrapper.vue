<template>
    <div>

        <div class="dropzone-container relative">
            <div class="dropzone-placeholder absolute z-0">
                <span v-html="getIcon('upload-cloud')" class="flex justify-center align-middle text-gray-600"></span>
                <span id="dropzone-text" class="block text-gray-600 ml-2">Drop your files here</span>
            </div>
            <div  id="dropzone" class="dropzone-previews w-full flex flex-wrap p-4 overflow-scroll h-full"></div>
        </div>


        <div id="dropzone-card-template" style="display:none">
            <div class="dz-preview dz-file-preview w-1/3">
                <div class="m-2">
                    <card-item>
                        <template v-slot:image>
                            <img class="w-full" data-dz-thumbnail />
                        </template>

                        <template v-slot:body>
                            <div class="dz-details">
                                <div class="block h-2"><span style="width: 0%" class="progress-bar h-full bg-teal-500 block"></span></div>
                                <small class="dz-filename flex justify-center text-center" data-dz-name></small>
                            </div>  
                        </template>

                        <template v-slot:footer>
                            <div class="flex flex-wrap justify-center">
                                <div class="dz-success-mark text-teal-500"><span v-html="getIcon('check')"></span></div>
                                <div class="dz-error-mark text-red-600"><span v-html="getIcon('alert-circle')"></span></div>
                                <div class="dz-error-message w-full text-red-600 text-center text-xs"></div>
                                <button class="btn btn-xs btn-default text-sm m-2 dropzone-hide">Hide</button>
                                <button class="btn btn-xs btn-danger text-sm m-2 dropzone-retry">Retry</button>
                            </div>
                        </template>
                    </card-item>
                </div>
            </div>    
        </div>

    </div>
</template>

<script>
    import _getIcon from '@helpers/getIcon'

    import Dropzone from 'dropzone'
    import CardItem from '@components/shared/CardItem'

    export default {

        props: {
            url: {
                required: true,
                type: String
            }
        },


        data(){  
            return {
                dropzone: null,
            }
        },


        mounted(){
            this.init();
        },


        components: {
            'card-item': CardItem
        },

        computed: {
            getToken(){
                const token = document.head.querySelector('meta[name="csrf-token"]');
                return token.content;
            },
            getSizeLimit(){
                return 5; // MB
            }
        },

        methods: {
            getIcon(icon) {
                return _getIcon(icon);
            },
            init(){
                const VM = this;
                const cardTemplate = document.querySelector('#dropzone-card-template').innerHTML;

                this.dropzone = new Dropzone("#dropzone", {
                    url: VM.url,
                    paramName: "upload",
                    maxFilesize: VM.getSizeLimit, 
                    previewsContainer: ".dropzone-previews",
                    headers: { "X-CSRF-TOKEN": VM.getToken },
                    previewTemplate: cardTemplate,
                    uploadprogress: (file, progress, bytesSent) => VM.handleProgress(file, progress, bytesSent),
                    error: (file, errorMessage, xhr) => VM.handleError(file, errorMessage, xhr),
                    success: (file, response) => VM.handleSuccess(file, response),
                    complete: file => VM.handleComplete(file),
                });
                
            },
            handleError(file, errorMessage, xhr){
                const vm = this;
                const msg = errorMessage?.message || errorMessage;
                const retryBtn = file.previewElement.querySelector('.dropzone-retry');
                
                file.previewElement.className += ' dz-error';
                file.previewElement.querySelector('.dz-error-message').innerHTML = msg;
                
                if (file.size / 1000000 > this.getSizeLimit) {
                    retryBtn.setAttribute("disabled", "true"); 
                    return;
                }

                retryBtn.addEventListener("click",() => {
                    file.previewElement.querySelector('.progress-bar').style.opacity = 1;
                    vm.dropzone.uploadFile(file);
                }, {once : true}); 
            },
            handleSuccess(file, response){
                const src = `data:image/jpeg;base64,${response.upload.encoded_image}`;

                file.previewElement.className += ' dz-success';
                file.previewElement.classList.remove("dz-error");
                file.previewElement.querySelector('.dz-error-message').innerHTML = '';
                file.previewElement.querySelector('img').setAttribute("src", src); 
                this.$emit('upload-success', response.upload);
            },
            handleComplete(file){
                const bar = file.previewElement.querySelector('.progress-bar');
                const hideBtn = file.previewElement.querySelector('.dropzone-hide');

                file.previewElement.className += ' dz-complete';
                document.querySelector('.dropzone-placeholder').innerHTML = '';

                hideBtn.addEventListener("click", function(){
                    file.previewElement.parentNode.removeChild(file.previewElement);
                }, {once : true}); 

                bar.style.opacity = 0;
                bar.style.width = 0 + "%";
                bar.classList.remove("progress-bar-animated");
            },
            handleProgress(file, progress, bytesSent){
                const bar = file.previewElement.querySelector('.progress-bar');

                bar.className += ' progress-bar-animated';
                bar.style.width = progress + "%";
            },


        }
        
    }
</script>

<style>
    .dropzone-container {
        @apply border-dashed border-2 w-full mb-4 rounded flex justify-center items-center;
        height: 350px;
    }

    .dropzone-container:hover {
        @apply bg-gray-200;
        cursor: pointer;
    }

    .dz-success-mark,
    .dz-error-mark,
    .dropzone-hide,
    .dropzone-retry {
        display:none;
    }

    .dz-error .dz-error-mark,
    .dz-error .dropzone-retry {
        display:block;
    }

    .dz-success .dz-success-mark {
        display:block;
    }

    .dz-complete .dropzone-hide {
        display:block;
    }

    .dropzone-container .progress-bar.progress-bar-animated {
        transition: all .2s ease-in-out;
    }

</style>