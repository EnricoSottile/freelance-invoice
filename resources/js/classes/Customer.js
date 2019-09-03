
const BASE_URI = 'app/customer';

class Customer {

    constructor(){
    }


    index(){
        return axios.get(BASE_URI);  
    }

    create(){
        return {
            full_name: null,
            email: null,
            phone: null,
            vat_code: null
        }
    }

    invoices(customerId){
        const uri = `${BASE_URI}/${customerId}/invoice`;
        return axios.get(uri)
    }

    payments(customerId){
        const uri = `${BASE_URI}/${customerId}/payment`;
        return axios.get(uri)
    }

    store(data){
        return axios.post(BASE_URI, data);
    }

    show(customerId){
        const uri = `${BASE_URI}/${customerId}`;
        return axios.get(uri);        
    }

    update(customerId, data){
        return axios.put(`${BASE_URI}/${customerId}`, data);
    }

    destroy(customerId){
        return axios.delete(`${BASE_URI}/${customerId}`);        
    }


}

export default Customer