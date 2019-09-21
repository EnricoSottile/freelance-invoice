import Payment from '@classes/Payment'
const paymentClass = Payment


describe('PaymentClass', () => {

    it('create methods return the correct object', () => {
        const id = 1;
        const expected = {  
            id: "",
            user_id: "",
            invoice_id: id,
            net_amount: "",
            due_date: "",
            payed_date: ""
        }


        expect(paymentClass.create(id)).toEqual(expected);
    })
 
    

})
