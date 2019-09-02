import { shallowMount } from '@vue/test-utils'
import PaymentRow from '../../../components/payment/PaymentRow'

import Payment from '../../../classes/Payment'
const paymentClass = new Payment();

const id = 1;
const mockPayment = {
  'id': id, 
  'user_id':1, 
  'invoice_id': 1, 
  'net_amount': 100, 
  'due_date': '2019-09-07 00:00:00', 
  'payed_date': null
};

paymentClass.destroy = jest.fn().mockReturnValue("response");
paymentClass.update = jest.fn().mockReturnValue(mockPayment);

const wrapper = shallowMount(PaymentRow, {
  propsData: {payment: mockPayment, paymentClass},
});



describe('PaymentRow', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })



  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = ['paymentBeingEdited'];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.paymentClass ).toBeInstanceOf(Payment);
    expect( wrapper.vm.paymentBeingEdited ).toBeNull();
    expect( wrapper.vm.payment ).toEqual(mockPayment);
  })

  test('computed return correct bool', () => {
    expect(wrapper.vm.isEditable).toBeTruthy();
    expect(wrapper.vm.isDestroyable).toBeTruthy();
  })


  test('it calls for destroy when clicking the button and emits correct event', async () => {
    const btn = wrapper.find('#destroyPayment_' + id)
    window.alert = () => {};
    window.router = {
      go: jest.fn()
    }
    btn.trigger('click')
    await expect(wrapper.vm.paymentClass.destroy).toBeCalled();
    expect( wrapper.emitted('paymentWasDeleted')[0]).toEqual(["response"])
  })



  test('edit button works correctly', async() => {
    const btnEdit = wrapper.find('#editPayment_' + id);
    btnEdit.trigger('click');
    expect( wrapper.vm.paymentBeingEdited).toEqual(mockPayment)
  })


  test('update button works correctly', async() => {
    window.alert = () => {};
    const btnUpdate = wrapper.find('#updatePayment_' + id);

    btnUpdate.trigger('click');
    await expect(wrapper.vm.paymentClass.update).toBeCalled();
    expect( wrapper.emitted('paymentWasUpdated')[0]).toEqual([mockPayment])
    await expect( wrapper.vm.paymentBeingEdited).toBeNull();
  })

  test('cancel button works correctly', async() => {
    const btnEdit = wrapper.find('#editPayment_' + id);
    btnEdit.trigger('click');

    const btnCancel = wrapper.find('#cancelEditPayment_' + id);
    btnCancel.trigger('click');
    expect( wrapper.vm.paymentBeingEdited).toEqual(null)
  });



})
