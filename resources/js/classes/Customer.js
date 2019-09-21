
const BASE_URI = 'app/customer';

class Customer {

    constructor(){
    }


    static index(){
        return axios.get(BASE_URI);  
    }

    static create(){
        return {
            full_name: '',
            email: '',
            phone: '',
            vat_code: ''
        }
    }

    static invoices(customerId){
        const uri = `${BASE_URI}/${customerId}/invoice`;
        return axios.get(uri)
    }

    static payments(customerId){
        const uri = `${BASE_URI}/${customerId}/payment`;
        return axios.get(uri)
    }

    static store(data){
        return axios.post(BASE_URI, data);
    }

    static show(customerId){
        const uri = `${BASE_URI}/${customerId}`;
        return axios.get(uri);        
    }

    static update(customerId, data){
        return axios.put(`${BASE_URI}/${customerId}`, data);
    }

    static destroy(customerId){
        return axios.delete(`${BASE_URI}/${customerId}`);        
    }


}

export default Customer