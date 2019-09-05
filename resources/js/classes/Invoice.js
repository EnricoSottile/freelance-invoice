
const BASE_URI = 'app/invoice';

class Invoice {

    constructor(){}


    static index(){
        return axios.get(BASE_URI);  
    }

    static create(customerId = null){
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

    static payments(invoiceId){
        const uri = `${BASE_URI}/${invoiceId}/payment`;
        return axios.get(uri)
    }

    static customers(invoiceId){
        // keep it simple for now
        // should the requirements change, do not touch CustomerController,
        // but create a new InvoiceCustomerController and a corresponding route
        const uri = `app/customer`;
        return axios.get(uri)
    }

    static store(data){
        return axios.post(BASE_URI, data);
    }

    static show(invoiceId){
        const uri = `${BASE_URI}/${invoiceId}`;
        return axios.get(uri);        
    }

    static update(invoiceId, data){
        return axios.put(`${BASE_URI}/${invoiceId}`, data);
    }

    static destroy(invoiceId){
        return axios.delete(`${BASE_URI}/${invoiceId}`);        
    }


}

export default Invoice