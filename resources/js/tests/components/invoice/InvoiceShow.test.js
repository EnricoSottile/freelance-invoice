import { shallowMount } from '@vue/test-utils'
import InvoiceShow from '../../../components/invoice/InvoiceShow'

import Invoice from '../../../classes/Invoice'
const invoiceClass = new Invoice();

const getInvoiceObj = {'id': 1};
const getInvoicePaymentsArr = [{id:1}, {id:2}];

invoiceClass.show = jest.fn().mockReturnValue({data: getInvoiceObj});
invoiceClass.payments = jest.fn().mockReturnValue({data: getInvoicePaymentsArr});
invoiceClass.destroy = jest.fn();

const wrapper = shallowMount(InvoiceShow, {
  propsData: {invoiceId: 1},
  // methods: {  },
  data: function() {
    return {
      invoiceClass
    }
  }
});



describe('InvoiceShow', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  test('calls for initial data load', () => {
    expect(wrapper.vm.invoiceClass.show).toBeCalled()
    expect(wrapper.vm.invoiceClass.payments).toBeCalled()
  })


  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
      'invoiceClass', 
      'invoice', 
      'payments', 
      'invoiceIsReady',
      'paymentsAreReady',
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.invoiceClass ).toBeInstanceOf(Invoice);
    expect( wrapper.vm.invoice ).toEqual(getInvoiceObj);
    expect( wrapper.vm.payments ).toEqual(getInvoicePaymentsArr);
    expect( wrapper.vm.invoiceIsReady ).toBeTruthy();
    expect( wrapper.vm.paymentsAreReady ).toBeTruthy();
  })


  test('it calls for destroy when clicking the button', () => {
    const btn = wrapper.find('#destroyInvoice')
    window.alert = () => {};
    window.router = {
      go: jest.fn()
    }
    btn.trigger('click')
    expect(wrapper.vm.invoiceClass.destroy).toBeCalled();
  })


})
