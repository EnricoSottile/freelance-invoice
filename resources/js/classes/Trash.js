
class Trash {


    static index(){
        return axios.get('app/trash');  
    }

    static restore(resource, id){
        return axios.get(`app/${resource}/${id}/restore`);        
    }
   
    static destroy(resource, id){
        return axios.delete(`app/${resource}/${id}/destroy`);        
    }


}

export default Trash