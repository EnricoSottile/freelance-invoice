<template>
    <div>
        <div>Upload</div>

            <div v-if="allowUploads">
                <div v-if="!imageSrc">
                    <h2>Select an image</h2>
                    <input type="file" @change="onFileChange">
                </div>
                <div v-else>
                    <img :src="imageSrc" style="max-width:100%; height:50px;"/>
                    <button id="removeImage" @click="removeImage">Remove image</button>
                    <button id="uploadImage" @click="uploadImage">Upload</button>
                </div>
            </div>

            <div>Uploaded files</div>
            <div>
                <ul>
                    <li                     
                        v-bind:key="upload.id" 
                        v-for="upload in uploads">
                        {{ upload.id }} - {{ upload.path }}
                        <img :src="'data:image/jpeg;base64,'+upload.encoded_image" style="max-width:100%; height:50px;"/>
                        <button v-if="allowDeletes" id="destroyUpload" @click="destroyUpload(upload.id)">Delete</button>
                    </li>

                </ul>
            </div>

    </div>
</template>

<script>
    import Upload from '@classes/Upload'
    const MODELS = ['invoice', 'customer', 'payment'];

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


        data(){  
            return {
                uploadClass: null,
                imageSrc: '',
                upload: '',
                uploads: [],
            }
        },

        mounted() {
            this.initClass();
            this.getUploads();
        },

        methods: {
            initClass(){
                this.uploadClass = new Upload(this.resourceType, this.resourceId)
            },
            async getUploads(){
                const { data: {uploads} } = await this.uploadClass.index();
                this.uploads = uploads;
            },
            async destroyUpload(uploadId){
                const response = await this.uploadClass.destroy(uploadId);
                alert("upload was deleted");
                this.uploads = this.uploads.filter(u => u.id !== uploadId);
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                this.createImage(files[0]);
            },
            createImage(file) {
                var imageSrc = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.imageSrc = e.target.result;
                };
                reader.readAsDataURL(file);
                this.upload = file;
            },
            removeImage: function (e) {
                this.imageSrc = '';
            },
            async uploadImage(){
                const response = await this.uploadClass.store(this.upload);
                this.uploads.push(response.data.upload);
                alert("image uploaded");
                this.removeImage();
            }
        },


    }
</script>

