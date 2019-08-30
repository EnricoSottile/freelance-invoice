import { shallowMount } from '@vue/test-utils'
import CustomerShow from '../../../components/customer/CustomerShow'

import Customer from '../../../classes/Customer'
const customerClass = new Customer();

const getCustomerObj = {'id': 1};
const getCustomerInvoicesArr = [{id:1}, {id:2}];

customerClass.show = jest.fn().mockReturnValue({data: getCustomerObj});
customerClass.invoices = jest.fn().mockReturnValue({data: getCustomerInvoicesArr});
customerClass.destroy = jest.fn();

const wrapper = shallowMount(CustomerShow, {
  propsData: {customerId: 1},
  // methods: {  },
  data: function() {
    return {
      customerClass
    }
  }
});



describe('CustomerShow', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  test('calls for initial data load', () => {
    expect(wrapper.vm.customerClass.show).toBeCalled()
    expect(wrapper.vm.customerClass.invoices).toBeCalled()
  })


  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
      'customerClass', 
      'customer', 
      'invoices', 
      'customerIsReady',
      'invoicesAreReady',
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.customerClass ).toBeInstanceOf(Customer);
    expect( wrapper.vm.customer ).toEqual(getCustomerObj);
    expect( wrapper.vm.invoices ).toEqual(getCustomerInvoicesArr);
    expect( wrapper.vm.customerIsReady ).toBeTruthy();
    expect( wrapper.vm.invoicesAreReady ).toBeTruthy();
  })



})
