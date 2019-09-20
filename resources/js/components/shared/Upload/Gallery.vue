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
                            <img class="w-full" :src="getUploadSource(upload)">
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
        
        <button v-if="files.length" class="btn btn-default" @click.prevent="toggleModal">Show existings</button>

    </div>
</template>

<script>
    import _formatDate from '@helpers/formatDate'
    import CardItem from '@components/shared/CardItem'
    import Modal from '@components/shared/Modal'

    export default {

        props: {
            files: {
                required: true,
                type: Array,
            },
            allowDeletes: {
                required: true,
                type: Boolean,
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
            formatDate(options, value) {
                return _formatDate(options, value)
            },
        }


    }
</script>

<style>

</style>