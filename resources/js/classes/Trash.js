
class Trash {


    static index(){
        return axios.get('app/trash');  
    }

    static show(resource, id){
        return axios.get(`app/${resource}/${id}/trashed`);  
    }

    static restore(resource, id){
        return axios.get(`app/${resource}/${id}/trashed/restore`);        
    }
   
    static destroy(resource, id){
        return axios.delete(`app/${resource}/${id}/trashed/destroy`);        
    }


}

export default Trash