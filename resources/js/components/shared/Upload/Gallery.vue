<template>
    <div>

        <modal v-on:close="toggleModal"
            :show="showExistingUploads">
            
            <div class="uploads-container">
                <div class="w-1/4 px-4 mb-4"
                        v-bind:key="upload.id" 
                        v-for="upload in files">
   
                    <card-item>
                        <template v-slot:image>
                            <div class="w-full h-full relative">
                                <img class="w-full" :src="getUploadSource(upload)">
                                <div class="image-overlay">
                                    <a v-html="getIcon('eye')" target="_blank" :href="getShowUrl(upload)"></a>
                                    <a v-html="getIcon('download')" :href="getDownloadUrl(upload)"></a>
                                </div>
                            </div>
                            
                        </template>

                        <template v-slot:body>
                            <small class="font-light text-xs">
                                Added: {{ formatDate({}, upload.created_at )}}
                            </small>
                        </template>

                        <template v-slot:footer>
                            <button class="btn btn-xs btn-danger text-sm my-2" v-if="allowDeletes" id="destroyUpload" @click="destroyUpload(upload.id)">Delete</button>
                        </template>
                    </card-item>
                </div>

            </div>

        </modal>
        
        <button v-if="loading" disabled class="btn btn-default">Loading</button>
        <template v-if="!loading">
            <button v-if="files.length" class="btn btn-default" @click.prevent="toggleModal">Show files</button>
            <button disabled v-else class="btn btn-default">No files to show</button>
        </template>
        

    </div>
</template>

<script>
    import _getIcon from '@helpers/getIcon'
    import _formatDate from '@helpers/formatDate'
    import CardItem from '@components/shared/CardItem'
    import Modal from '@components/shared/Modal'

    export default {

        props: {
            uploadClass: {
                required: true,
                type: [Object, Function]
            },
            files: {
                required: true,
                type: Array,
            },
            allowDeletes: {
                required: true,
                type: Boolean,
            },
            loading: {
                required: false,
                type: Boolean,
                default: true,
            }
        },

        components: {
            'modal': Modal,
            'card-item': CardItem
        },
        
        data(){
            return {
                showExistingUploads: false,
            }
        },

        watch: {
            files(a,b) {
                if (a.length === 0) this.showExistingUploads = false;
            }
        },

        methods: {
            getUploadSource(upload){
                const src = `data:image/jpeg;base64,${upload.encoded_image}`;
                return src;
            },
            toggleModal(){
                this.showExistingUploads = !this.showExistingUploads;
            },
            destroyUpload(fileId){
                this.$emit('destroy', fileId);
            },
            getShowUrl(upload){
                return this.uploadClass.getShowUrl(upload.id);
            },
            getDownloadUrl(upload){
                return this.uploadClass.getDownloadUrl(upload.id);
            },

            formatDate(options, value) {
                return _formatDate(options, value)
            },
            getIcon(icon) {
                return _getIcon(icon);
            },
        }


    }
</script>

<style>

    .image-overlay {
        transition: all .2s ease-in-out;
        @apply w-full h-full top-0 bg-black opacity-0 absolute flex justify-center items-center;
    }

    .image-overlay a {
        transition: all .1s ease-in-out;
        @apply text-white opacity-50 mx-2;
    }

    .image-overlay a:hover {
        @apply opacity-100;
    }

    .image-overlay:hover {
        @apply opacity-75;
    }

</style>