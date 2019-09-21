
class Upload {


    constructor(resourceType, resourceId){
        this.url = `app/${resourceType}/${resourceId}/upload`;
    }

    getUploadUrl(){
        return this.url;
    }

    index(){
        return axios.get(this.url);  
    }


    // store(file){
    //     const url = this.url;
    //     let data = new FormData();
    //     data.append('upload', file); 

    //     return axios({
    //         method: 'post',
    //         url,
    //         data,
    //         config: { headers: {'Content-Type': 'multipart/form-data' }}
    //     })
    // }

   
    destroy(uploadId){
        return axios.delete(`${this.url}/${uploadId}`);        
    }


}

export default Upload