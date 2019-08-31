import { shallowMount } from '@vue/test-utils'
import AddPayment from '../../../components/payment/AddPayment'

import Payment from '../../../classes/Payment'
const paymentClass = new Payment();

const mockInvoice = {
    id: 1,
}

const mockCreate = {
    id: null,
    user_id: null,
    invoice_id: mockInvoice.id,
    net_amount: null,
    due_date: null,
    payed_date: null
}
const mockPayment = {
  'id': 1, 
  'user_id':1, 
  'invoice_id': 1, 
  'net_amount': 100, 
  'due_date': '2019-09-07 00:00:00', 
  'payed_date': '2019-09-07 00:00:00'
};

paymentClass.create = jest.fn().mockReturnValue(mockCreate);
paymentClass.store = jest.fn().mockReturnValue(mockPayment);

const wrapper = shallowMount(AddPayment, {
  propsData: {paymentClass, invoice: mockInvoice},
});



describe('PaymentRow', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })


  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
        'newPayment'
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());
    expect( wrapper.vm.newPayment ).toBeNull();
  })


  test('add button works correctly', async() => {
    const btnAdd = wrapper.find('#addPayment');
    btnAdd.trigger('click');
    await expect(wrapper.vm.paymentClass.create).toBeCalled();
    expect( wrapper.vm.newPayment).toEqual(mockCreate)
  })


  test('save button works correctly', async() => {
    window.alert = () => {};
    const btnSave = wrapper.find('#saveNewPayment');
    btnSave.trigger('click');
    await expect(wrapper.vm.paymentClass.store).toBeCalled();
    expect( wrapper.emitted('paymentWasSaved')[0]).toEqual([mockPayment])
  })

  test('cancel button works correctly', async() => {
    const btnAdd = wrapper.find('#addPayment');
    btnAdd.trigger('click');

    const btnCancel = wrapper.find('#cancelNewPayment');
    btnCancel.trigger('click');
    await expect(wrapper.vm.paymentClass.create).toBeCalled();
    expect( wrapper.vm.newPayment).toEqual(null)
  });


})
