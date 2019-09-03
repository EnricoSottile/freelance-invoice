import { shallowMount } from '@vue/test-utils'
import InvoiceCreate from '../../../components/invoice/InvoiceCreate'
import Invoice from '../../../classes/Invoice'

const invoiceClass = jest.fn();

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


const stubReturnStoredInvoice = jest.fn().mockReturnValue({data: {invoice: mockInvoice}});

invoiceClass.store = stubReturnStoredInvoice
invoiceClass.create = jest.fn().mockReturnValue(mockCreate);

const mockData = [{id:1}, {id:2}]
invoiceClass.customers = jest.fn().mockReturnValue({data: mockData});



const wrapper = shallowMount(InvoiceCreate,{
  data: function() {
    return {
      invoiceClass
    }
  }
});



describe('InvoiceCreate', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })


  test('initial data params are correct', async () => {
    const data = wrapper.vm._data;
    const expectedData = [
        'invoiceClass', 'invoice', 'customers', 'customersAreReady'
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());
    // expect( wrapper.vm.invoiceClass ).toBeInstanceOf(Invoice);
    expect( wrapper.vm.invoice ).toEqual(mockCreate);

    await wrapper.vm.getCustomers();
    expect( wrapper.vm.customers ).toEqual(mockData);  
    expect( wrapper.vm.customersAreReady ).toBeTruthy();
  })



  test('save button works correctly', async() => {
    window.alert = () => {};
    window.router = {
      push: () => {},
    };

    
    await wrapper.vm.getCustomers();
    const btnSave = wrapper.find('#saveNewInvoice');
    btnSave.trigger('click');
    await expect(wrapper.vm.invoiceClass.store).toBeCalled();
  })  


  test('invoice create from customer sets the id correctly', () => {
    const id = 100;
    const wrapper2 = shallowMount(InvoiceCreate, {
      propsData: {customerId: id},
      data: function() {
        return {
          invoiceClass
        }
      }
    });

    expect(wrapper2.vm.invoice.customer_id).toBe(id);
  })

})
  