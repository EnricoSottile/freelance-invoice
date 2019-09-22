import { shallowMount } from '@vue/test-utils'
import InvoiceShow from '@components/invoice/InvoiceShow'

import Invoice from '@classes/Invoice'
const invoiceClass = new Invoice();

const getInvoiceObj = {'id': 1,registered_date: null};
const getInvoicePaymentsArr = [{id:1}, {id:2}];
const mockUpdatedInvoice ={id:1, foo: 'bar', registered_date: null}
const mockData = [{id:1}, {id:2}]
invoiceClass.show = jest.fn().mockReturnValue({data: getInvoiceObj});
invoiceClass.payments = jest.fn().mockReturnValue({data: getInvoicePaymentsArr});
invoiceClass.destroy = jest.fn();
invoiceClass.update = jest.fn().mockReturnValue({data: {invoice: mockUpdatedInvoice}});
invoiceClass.customers = jest.fn().mockReturnValue({data: mockData});

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
      'invoiceBeingEdited',
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.invoiceClass ).toBeInstanceOf(Invoice);
    expect( wrapper.vm.invoice ).toEqual(getInvoiceObj);
    expect( wrapper.vm.payments ).toEqual(getInvoicePaymentsArr);
    expect( wrapper.vm.invoiceIsReady ).toBeTruthy();
    expect( wrapper.vm.paymentsAreReady ).toBeTruthy();
    expect( wrapper.vm.invoiceBeingEdited ).toBeNull();
  })

  test('computed return correct bool', () => {
    expect(wrapper.vm.hasPayedPayments).toBeFalsy();
    expect(wrapper.vm.isEditable).toBeTruthy();
    expect(wrapper.vm.isDestroyable).toBeTruthy();
  })


  // test('it calls for destroy when clicking the button', () => {
  //   const btn = wrapper.find('#destroyInvoice')
  //   window.alert = () => {};
  //   window.router = {
  //     go: jest.fn()
  //   }
  //   btn.trigger('click')
  //   expect(wrapper.vm.invoiceClass.destroy).toBeCalled();
  // })


  // test('edit button works correctly', async() => {
  //   const btnEdit = wrapper.find('#editInvoice');
  //   btnEdit.trigger('click');
  //   expect( wrapper.vm.invoiceBeingEdited).toEqual(getInvoiceObj)
  // })


  // test('update button works correctly', async() => {
  //   window.alert = () => {};
  //   const btnUpdate = wrapper.find('#updateInvoice');

  //   btnUpdate.trigger('click');
    
  //   await expect(wrapper.vm.invoiceClass.update).toBeCalled();
  //   await expect( wrapper.vm.invoiceBeingEdited).toBeNull();
  //   await expect( wrapper.vm.invoice).toEqual(mockUpdatedInvoice);
  // })

  // test('cancel button works correctly', async() => {
  //   const btnEdit = wrapper.find('#editInvoice');
  //   btnEdit.trigger('click');

  //   const btnCancel = wrapper.find('#cancelEditInvoice');
  //   btnCancel.trigger('click');
  //   expect( wrapper.vm.invoiceBeingEdited).toEqual(null)
  // });


})
