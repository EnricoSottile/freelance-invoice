<template>
    <div>
        <div>Upload</div>

            <div v-if="allowUploads">
                <div v-if="!filesSrc.length">
                    <h2>Select a file/s</h2>
                    <input type="file" multiple @change="onFileChange">
                </div>
                <div v-else >
                    <div v-for="(file, key) in filesSrc" v-bind:key="key">
                        <img :src="file.src" style="max-width:100%; height:50px;"/>
                        <button id="removeFile" @click="removeFile(file.id)">Remove image</button>
                    </div>
                    <button id="uploadFiles" @click="uploadFiles">Upload</button>
                </div>
            </div>

            <gallery @destroy="destroyUpload($event)" :allowDeletes="allowDeletes" :files="existingUploads"></gallery>

    </div>
</template>

<script>
    const MODELS = ['invoice', 'customer', 'payment'];


    import Gallery from './Gallery'
    import Upload from '@classes/Upload'

    export default {

        props: {
            resourceType: {
                required: true,
                type: String,
                validator(value) {
                    return MODELS.includes(value);
                }
            },
            resourceId: {
                required: true,
                type: [String, Number]
            },
            allowUploads: {
                required: true,
                type: Boolean,
            },
            allowDeletes: {
                required: true,
                type: Boolean,
            }
        },

        components: {
            'gallery': Gallery,
        },


        data(){  
            return {
                uploadClass: null,
                filesSrc: [],
                filesToUpload: [],
                existingUploads: [],
            }
        },

        created() {
            this.initClass();
            this.getUploads();
        },


        methods: {
            initClass(){
                this.uploadClass = new Upload(this.resourceType, this.resourceId)
            },
            async getUploads(){
                const { data: {uploads} } = await this.uploadClass.index();
                this.existingUploads = uploads;
            },
            async destroyUpload(uploadId){
                const response = await this.uploadClass.destroy(uploadId);
                alert("upload was deleted");
                this.existingUploads = this.existingUploads.filter(u => u.id !== uploadId);
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i]
                    this.createImage(files[i]);
                }
            },
            createImage(file) {
                const id = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                const filesSrc = new Image();
                const reader = new FileReader();
                const vm = this;

                reader.onload = (e) => {
                    vm.filesSrc.push( {id, src: e.target.result } );
                };
                reader.readAsDataURL(file);
                this.filesToUpload.push({id, data: file});
            },
            removeFile(fileId) {
                this.filesSrc = this.filesSrc.filter(f => f.id !== fileId);
            },
            uploadFiles(){
                this.filesToUpload.forEach(async (file) => {
                    const response = await this.uploadClass.store(file.data);
                    this.existingUploads.push(response.data.upload);
                    console.log("image uploaded", file, response.data.upload);
                    this.removeFile(file.id);
                });
            },
        },


    }
</script>

<style>

    .modal .modal-content {
        @apply bg-gray-200;
    }

    .uploads-container {
        @apply rounded flex flex-wrap  pt-4;
    }


</style>