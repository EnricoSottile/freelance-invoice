import { shallowMount } from '@vue/test-utils'
import PaymentShow from '../../../components/payment/PaymentShow'

import Payment from '../../../classes/Payment'
const paymentClass = new Payment();

const getPaymentObj = {'id': 1};

paymentClass.show = jest.fn().mockReturnValue({data: getPaymentObj});
paymentClass.destroy = jest.fn();

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
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.paymentClass ).toBeInstanceOf(Payment);
    expect( wrapper.vm.payment ).toEqual(getPaymentObj);
    expect( wrapper.vm.paymentIsReady ).toBeTruthy();
  })


  test('it calls for destroy when clicking the button', () => {
    const btn = wrapper.find('#destroyPayment')
    window.alert = () => {};
    window.router = {
      go: jest.fn()
    }
    btn.trigger('click')
    expect(wrapper.vm.paymentClass.destroy).toBeCalled();
  })


})
