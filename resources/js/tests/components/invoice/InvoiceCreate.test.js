import { shallowMount } from '@vue/test-utils'
import InvoiceCreate from '../../../components/invoice/InvoiceCreate'

import Invoice from '../../../classes/Invoice'
// const invoiceClass = new Invoice();

const mockCustomer = {
    id: 1,
}

const mockCreate = {
  customer_id: null,
  number: null,
  net_amount: null,
  tax: null,
  description: null,
  date: null,
  sent_date: null,
  registered_date: null
}
const mockInvoice = {
  customer_id: mockCustomer.id,
  number: 1,
  net_amount: 2,
  tax: 3,
  description: 'quattro',
  date: '2019-09-07 00:00:00',
  sent_date: '2019-09-07 00:00:00',
  registered_date: null
};



const wrapper = shallowMount(InvoiceCreate);
const stubReturnStoredInvoice = jest.fn().mockReturnValue({data: {invoice: mockInvoice}});


describe('InvoiceCreate', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })


  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
        'invoiceClass', 'invoice'
    ];
    
    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());
    expect( wrapper.vm.invoiceClass ).toBeInstanceOf(Invoice);
    expect( wrapper.vm.invoice ).toEqual(mockCreate);
  })




  test('save button works correctly', async() => {
    window.alert = () => {};
    window.router = {
      push: () => {},
    };
    wrapper.vm.invoiceClass.store = stubReturnStoredInvoice;
    const btnSave = wrapper.find('#saveNewInvoice');
    btnSave.trigger('click');
    // await expect(wrapper.vm.invoiceClass.store).toBeCalled();
    await expect(wrapper.vm.invoiceClass.store).toBeCalled();
  })  


  test('invoice create from customer sets the id correctly', () => {
    const id = 100;
    const wrapper2 = shallowMount(InvoiceCreate, {
      propsData: {customerId: id},
    });

    expect(wrapper2.vm.invoice.customer_id).toBe(id);
  })

})
  