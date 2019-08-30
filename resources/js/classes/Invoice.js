
const BASE_URI = 'app/invoice';

class Invoice {

    constructor(){}


    index(){
        return axios.get(BASE_URI);  
    }

    payments(invoiceId){
        const uri = `${BASE_URI}/${invoiceId}/payment`;
        return axios.get(uri)
    }

    store(data){
        return axios.post(BASE_URI, data);
    }

    show(invoiceId){
        const uri = `${BASE_URI}/${invoiceId}`;
        return axios.get(uri);        
    }

    update(invoice){
        return axios.put(BASE_URI, data);
    }

    destroy(invoiceId){
        return axios.delete(`${BASE_URI}/${invoiceId}`);        
    }


}

export default Invoice