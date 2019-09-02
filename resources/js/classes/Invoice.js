
const BASE_URI = 'app/invoice';

class Invoice {

    constructor(){}


    index(){
        return axios.get(BASE_URI);  
    }

    create(customerId = null){
        return {
            customer_id: customerId,
            number: null,
            net_amount: null,
            tax: null,
            description: null,
            date: null,
            sent_date: null,
            registered_date: null
        }
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

    update(invoiceId, data){
        return axios.put(`${BASE_URI}/${invoiceId}`, data);
    }

    destroy(invoiceId){
        return axios.delete(`${BASE_URI}/${invoiceId}`);        
    }


}

export default Invoice