
const BASE_URI = 'app/customer';

class Customer {

    constructor(){
    }


    index(){
        return axios.get(BASE_URI);  
    }

    invoices(customerId){
        const uri = `${BASE_URI}/${customerId}/invoice`;
        return axios.get(uri)
    }

    store(data){
        return axios.post(BASE_URI, data);
    }

    show(customerId){
        const uri = `${BASE_URI}/${customerId}`;
        return axios.get(uri);        
    }

    update(customer){
        return axios.put(BASE_URI, data);
    }

    destroy(customerId){
        return axios.delete(`${BASE_URI}/${customerId}`);        
    }


}

export default Customer