
const BASE_URI = 'app/payment';

class Payment {

    constructor(){}


    static index(){
        return axios.get(BASE_URI);  
    }

    static create(invoiceId = ''){
        return {
            id: '',
            user_id: '',
            invoice_id: invoiceId,
            net_amount: '',
            due_date: '',
            payed_date: ''
        }
    }

    static invoices(paymentId){
        // keep it simple for now
        // should the requirements change, do not touch InvoiceController,
        // but create a new PaymentInvoiceController and a corresponding route
        const uri = `app/invoice`;
        return axios.get(uri)
    }

    static store(data){
        return axios.post(BASE_URI, data);
    }

    static show(paymentId){
        const uri = `${BASE_URI}/${paymentId}`;
        return axios.get(uri);        
    }

    static update(paymentId, data){
        return axios.put(`${BASE_URI}/${paymentId}`, data);
    }

    static destroy(paymentId){
        return axios.delete(`${BASE_URI}/${paymentId}`);        
    }


}

export default Payment