import Payment from '../../classes/Payment'
const paymentClass = Payment


describe('PaymentClass', () => {

    it('create methods return the correct object', () => {
        const id = 1;
        const expected = {
            id: null,
            user_id: null,
            invoice_id: id,
            net_amount: null,
            due_date: null,
            payed_date: null
        }
        expect(paymentClass.create(id)).toEqual(expected);
    })

    

})
