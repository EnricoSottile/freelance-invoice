import { shallowMount } from '@vue/test-utils'
import PaymentShow from '@components/payment/PaymentShow'

import Payment from '@classes/Payment'
const paymentClass = Payment;

const getPaymentObj = {'id': 1,payed_date: null};
paymentClass.show = jest.fn().mockReturnValue({data: getPaymentObj});

const wrapper = shallowMount(PaymentShow, {
  propsData: {paymentId: 1},
  // methods: {  },
  data: function() {
    return {
      paymentClass
    }
  }
});



describe('PaymentShow', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  test('calls for initial data load', () => {
    expect(wrapper.vm.paymentClass.show).toBeCalled()
  })


  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
      'paymentClass', 
      'payment', 
      'paymentIsReady',
      'paymentBeingEdited'
    ];
  
    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.payment ).toEqual(getPaymentObj);
    expect( wrapper.vm.paymentIsReady ).toBeTruthy();
  })

  test('computed return correct bool', () => {
    expect(wrapper.vm.isEditable).toBeTruthy();
    expect(wrapper.vm.isDestroyable).toBeTruthy();
  })

})
