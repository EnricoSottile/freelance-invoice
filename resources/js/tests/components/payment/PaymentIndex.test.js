import { shallowMount } from '@vue/test-utils'
import PaymentIndex from '@components/payment/PaymentIndex'

import Payment from '@classes/Payment'
const paymentClass = Payment;

const getPaymentsObj = [{id:1}, {id:2}];
paymentClass.index = jest.fn().mockReturnValue({data: getPaymentsObj});

const mount = (shouldHandleOwnLoading = true, filteredPayments = null, invoice = null) => {
 return shallowMount(PaymentIndex, {
    stubs: ['router-link'],
    propsData: {shouldHandleOwnLoading, filteredPayments, invoice},
    data: function() {
      return {
        paymentClass
      }
    }
  });
}




let wrapper;

describe('PaymentIndex without own loading', () => {
  
  const payments = [{id:3}, {id:4}];
  const invoice = {id: 1};
  test('is a Vue instance', () => {
    wrapper = mount(false, payments, invoice);
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  test('loads data correctly', () => {
    expect(wrapper.vm.paymentClass.index).not.toBeCalled()
    expect(wrapper.vm.payments).toEqual(payments)
  })

})


describe('PaymentIndex with own loading', () => {

  test('is a Vue instance', () => {
    wrapper = mount();
    expect(wrapper.isVueInstance()).toBeTruthy()    
  })

  test('has correct initial data keys', () => {
    const data = wrapper.vm._data;
    const expectedData = [
      'paymentClass', 
      'payments', 
      'paymentsAreReady'
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());
})

  test('loads data correctly', () => {
    expect(wrapper.vm.paymentClass.index).toBeCalled()
    expect(wrapper.vm.payments).toEqual(getPaymentsObj)
    expect(wrapper.vm.paymentsAreReady).toBeTruthy()
  })


  test('correctly removes the deleted payment from the array', () => {
      window.alert = () => {};
      wrapper.vm.payments = [
        {id:1},
        {id:2},
        {id:3},
        {id:4},
      ];     

      wrapper.vm.handlePaymentWasDeleted('evt', 2);

      expect(wrapper.vm.payments).toEqual([{id:1},{id:3},{id:4}]);
  })


  test('correctly adds the new payment to the array', () => {
    window.alert = () => {};
    wrapper.vm.payments = [
      {id:1},
      {id:2},
      {id:3},
    ];     

    const newPayment = { data: {payment: {id: 4}}};

    wrapper.vm.handlePaymentWasSaved(newPayment);
    expect(wrapper.vm.payments).toEqual([{id:1},{id:2},{id:3},{id:4}]);
})


test('correctly updates the payment in the array', () => {
    window.alert = () => {};
    window.Vue = require('vue');
    wrapper.vm.payments = [
      {id:1},
      {id:2},
      {id:3, test: 'abc'},
    ];     

    const updatedPayment = { data: {payment: {id: 3, test:'def'}}};
    wrapper.vm.handlePaymentWasUpdated(updatedPayment);
    expect(wrapper.vm.payments).toEqual([{id:1},{id:2},{id:3, test: 'def'}]);
  })  
  
})    
  
   
