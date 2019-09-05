
const BASE_URI = 'app/payment';

class Payment {

    constructor(){}


    static index(){
        return axios.get(BASE_URI);  
    }

    static create(invoiceId){
        return {
            id: null,
            user_id: null,
            invoice_id: invoiceId,
            net_amount: null,
            due_date: null,
            payed_date: null
        }
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