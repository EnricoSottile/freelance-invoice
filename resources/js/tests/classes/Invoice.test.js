import Invoice from '../../classes/Invoice'
const invoiceClass = Invoice


describe('InvoiceClass', () => {

    it('create methods return the correct object', () => {
        const id = 1;
        const expected = {
            customer_id: id,
            number: null,
            net_amount: null,
            tax: null,
            description: null,
            date: null,
            sent_date: null,
            registered_date: null
        }
        expect(invoiceClass.create(id)).toEqual(expected);
    })

    

})
