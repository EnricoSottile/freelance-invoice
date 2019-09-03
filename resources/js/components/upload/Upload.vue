<template>
    <div>
        <div>Upload</div>

            <div>
                <div v-if="!image">
                    <h2>Select an image</h2>
                    <input type="file" @change="onFileChange">
                </div>
                <div v-else>
                    <img :src="image" style="max-width:100%; height:100px;"/>
                    <button @click="removeImage">Remove image</button>
                    <button @click="uploadImage">Upload</button>
                </div>
            </div>

    </div>
</template>

<script>

    export default {


        data(){
            return {
                image: '',
                upload: ''
            }
        },

        computed: {

        },

        methods: {
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
                this.upload = file;
            },
            removeImage: function (e) {
                this.image = '';
            },
            async uploadImage(){
                const URL = 'app/upload/invoice/1'; 

    var bodyFormData = new FormData();
    bodyFormData.append('image', this.upload); 



                axios({
                    method: 'post',
                    url: URL,
                    data: bodyFormData,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                    })
                    .then(function (response) {
                        //handle success
                        console.log(response);
                    });

            }
        },


    }
</script>

