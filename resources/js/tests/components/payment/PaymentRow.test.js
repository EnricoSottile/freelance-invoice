import { shallowMount } from '@vue/test-utils'
import PaymentRow from '../../../components/payment/PaymentRow'

import Payment from '../../../classes/Payment'
const paymentClass = new Payment();

const mockPayment = {
  'id': 1, 
  'user_id':1, 
  'invoice_id': 1, 
  'net_amount': 100, 
  'due_date': '2019-09-07 00:00:00', 
  'payed_date': '2019-09-07 00:00:00'
};

paymentClass.destroy = jest.fn().mockReturnValue("response");

const wrapper = shallowMount(PaymentRow, {
  propsData: {payment: mockPayment},
  // methods: {  },
  data: function() {
    return {
      paymentClass
    }
  }
});



describe('PaymentRow', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })



  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
      'paymentClass', 
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.paymentClass ).toBeInstanceOf(Payment);
    expect( wrapper.vm.payment ).toEqual(mockPayment);
  })


  test('it calls for destroy when clicking the button and emits correct event', async () => {
    const btn = wrapper.find('#destroyPayment')
    window.alert = () => {};
    window.router = {
      go: jest.fn()
    }
    btn.trigger('click')
    await expect(wrapper.vm.paymentClass.destroy).toBeCalled();
    expect( wrapper.emitted('paymentWasDeleted')[0]).toEqual(["response"])
  })



})
