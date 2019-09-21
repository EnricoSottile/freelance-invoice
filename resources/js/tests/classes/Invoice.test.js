import Invoice from '@classes/Invoice'
const invoiceClass = Invoice


describe('InvoiceClass', () => {

    it('create methods return the correct object', () => {
        const id = 1;
        const expected = {
            customer_id: id,
            number: '',
            net_amount: '',
            tax: '',
            description: '',
            date: '',
            sent_date: '',
            registered_date: ''
        }
        expect(invoiceClass.create(id)).toEqual(expected);
    })

    

})
