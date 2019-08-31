import { shallowMount } from '@vue/test-utils'
import PaymentIndex from '../../../components/payment/PaymentIndex'

import Payment from '../../../classes/Payment'
const paymentClass = new Payment();

const getPaymentsObj = [{id:1}, {id:2}];
paymentClass.index = jest.fn().mockReturnValue({data: getPaymentsObj});

const mount = (shouldHandleOwnLoading = true, filteredPayments = null) => {
 return shallowMount(PaymentIndex, {
    stubs: ['router-link'],
    propsData: {shouldHandleOwnLoading, filteredPayments},
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
  test('is a Vue instance', () => {
    wrapper = mount(false, payments);
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

})

   
