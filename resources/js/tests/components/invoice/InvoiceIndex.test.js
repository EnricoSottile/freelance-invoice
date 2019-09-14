import { shallowMount } from '@vue/test-utils'
import InvoiceIndex from '@components/invoice/Index/InvoiceIndex'

import Invoice from '@classes/Invoice'
const invoiceClass = new Invoice();

const getInvoicesObj = [{id:1}, {id:2}];
invoiceClass.index = jest.fn().mockReturnValue({data: getInvoicesObj});

const mount = (shouldHandleOwnLoading = true, filteredInvoices = null) => {
 return shallowMount(InvoiceIndex, {
    stubs: ['router-link'],
    propsData: {shouldHandleOwnLoading, filteredInvoices},
    data: function() {
      return {
        invoiceClass
      }
    }
  });
}




let wrapper;

describe('InvoiceIndex without own loading', () => {
  
  const invoices = [{id:3}, {id:4}];
  test('is a Vue instance', () => {
    wrapper = mount(false, invoices);
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  test('loads data correctly', () => {
    expect(wrapper.vm.invoiceClass.index).not.toBeCalled()
    expect(wrapper.vm.invoices).toEqual(invoices)
    expect(wrapper.vm.invoicesAreReady).toBeTruthy()
  })

})


describe('InvoiceIndex with own loading', () => {

  test('is a Vue instance', () => {
    wrapper = mount();
    expect(wrapper.isVueInstance()).toBeTruthy()    
  })

  test('loads data correctly', () => {
    expect(wrapper.vm.invoiceClass.index).toBeCalled()
    expect(wrapper.vm.invoices).toEqual(getInvoicesObj)
    expect(wrapper.vm.invoicesAreReady).toBeTruthy()
  })


  test('has correct initial data keys', () => {
      const data = wrapper.vm._data;
      const expectedData = [
        'invoiceClass', 
        'invoices', 
        'invoicesAreReady',
        'fields'
      ];
  
      expect( Object.keys(data).sort() ).toEqual(expectedData.sort());
  })

})


