import { shallowMount } from '@vue/test-utils'
import CustomerShow from '../../../components/customer/CustomerShow'

import Customer from '../../../classes/Customer'
const customerClass = new Customer();

const getCustomerObj = {'id': 1};
const getCustomerInvoicesArr = [{id:1}, {id:2}];
const getCustomerPaymentsArr = [{id:10}, {id:20}];

customerClass.show = jest.fn().mockReturnValue({data: getCustomerObj});
customerClass.invoices = jest.fn().mockReturnValue({data: getCustomerInvoicesArr});
customerClass.payments = jest.fn().mockReturnValue({data: getCustomerPaymentsArr});
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
      'payments',
      'customerIsReady',
      'invoicesAreReady',
      'paymentsAreReady'
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.customerClass ).toBeInstanceOf(Customer);
    expect( wrapper.vm.customer ).toEqual(getCustomerObj);
    expect( wrapper.vm.invoices ).toEqual(getCustomerInvoicesArr);
    expect( wrapper.vm.payments ).toEqual(getCustomerPaymentsArr);
    expect( wrapper.vm.customerIsReady ).toBeTruthy();
    expect( wrapper.vm.invoicesAreReady ).toBeTruthy();
    expect( wrapper.vm.paymentsAreReady ).toBeTruthy();
  })


  test('computed return correct bool', () => {
    expect(wrapper.vm.hasPayedPayments).toBeFalsy();
    expect(wrapper.vm.hasRegisteredInvoices).toBeFalsy();
    expect(wrapper.vm.isEditable).toBeTruthy();
    expect(wrapper.vm.isDestroyable).toBeTruthy();

    wrapper.vm.invoices.push({id: 100, registered_date: '2019-09-07 00:00:00'});
    expect(wrapper.vm.hasRegisteredInvoices).toBeTruthy();
    expect(wrapper.vm.isEditable).toBeFalsy();
    expect(wrapper.vm.isDestroyable).toBeFalsy();

    wrapper.vm.invoices.pop();
    wrapper.vm.payments.push({id: 100, payed_date: '2019-09-07 00:00:00'});
    expect(wrapper.vm.hasPayedPayments).toBeTruthy();
    expect(wrapper.vm.isEditable).toBeFalsy();
    expect(wrapper.vm.isDestroyable).toBeFalsy();
  })



})
