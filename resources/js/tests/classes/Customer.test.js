import Customer from '@classes/Customer'
const customerClass = Customer


describe('CustomerClass', () => {

    it('create methods return the correct object', () => {
        const expected = {
            full_name: null,
            email: null,
            phone: null,
            vat_code: null
        }
        expect(customerClass.create()).toEqual(expected);
    })

    

})
