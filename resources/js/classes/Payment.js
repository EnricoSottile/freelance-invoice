
const BASE_URI = 'app/payment';

class Payment {

    constructor(){}


    index(){
        return axios.get(BASE_URI);  
    }

    create(invoiceId){
        return {
            id: null,
            user_id: null,
            invoice_id: invoiceId,
            net_amount: null,
            due_date: null,
            payed_date: null
        }
    }

    store(data){
        return axios.post(BASE_URI, data);
    }

    // show(paymentId){
    //     const uri = `${BASE_URI}/${paymentId}`;
    //     return axios.get(uri);        
    // }

    update(invoice){
        return axios.put(BASE_URI, data);
    }

    destroy(paymentId){
        return axios.delete(`${BASE_URI}/${paymentId}`);        
    }


}

export default Payment