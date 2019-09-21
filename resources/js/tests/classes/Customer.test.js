import Customer from '@classes/Customer'
const customerClass = Customer


describe('CustomerClass', () => {

    it('create methods return the correct object', () => {
        const expected = {
            full_name: '',
            email: '',
            phone: '',
            vat_code: ''
        }
        expect(customerClass.create()).toEqual(expected);
    })

    

})
