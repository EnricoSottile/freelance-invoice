<template>
    <div>

            <h2 class="font-light text-gray-600">File uploads</h2>
            <div v-if="allowUploads">
                <dropzone-wrapper @upload-success="handleUpload($event)" :url="getUploadUrl"/>
            </div>

            <gallery :uploadClass="uploadClass" :loading="!galleryIsReady" @destroy="destroyUpload($event)" :allowDeletes="allowDeletes" :files="existingUploads"></gallery>

    </div>
</template>

<script>
    const MODELS = ['invoice', 'customer', 'payment'];

    import SweetAlert from '@classes/SweetAlert'    
    import DropzoneWrapper from './DropzoneWrapper'
    

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
            'dropzone-wrapper': DropzoneWrapper
        },


        data(){  
            return {
                uploadClass: null,
                existingUploads: [],
                galleryIsReady: false,
            }
        },

        created() {
            this.initClass();
            this.getUploads();
        },

        computed: {
            getUploadUrl(){
                return this.uploadClass.getUploadUrl();
            }
        },


        methods: {
            initClass(){
                this.uploadClass = new Upload(this.resourceType, this.resourceId)
            },
            async getUploads(){
                this.galleryIsReady = false;
                const { data: {uploads} } = await this.uploadClass.index();
                this.existingUploads = uploads;
                this.galleryIsReady = true;
            },
            async destroyUpload(uploadId){
                const canDelete = await SweetAlert.confirmDelete('file', {
                    text: `This file will be permanentyle deleted and will not be recoverable.`,
                    confirmButtonText: 'Yes, delete it forever'
                });
                if (canDelete === false) return;
                
                const response = await this.uploadClass.destroy(uploadId);
                SweetAlert.fire('Deleted!', `The payment has been deleted.`, 'success');
                this.existingUploads = this.existingUploads.filter(u => u.id !== uploadId);
            },
            handleUpload(upload) {
                this.existingUploads.push(upload);
            }
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