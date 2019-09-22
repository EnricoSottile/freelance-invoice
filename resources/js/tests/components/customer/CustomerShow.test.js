import { shallowMount } from '@vue/test-utils'
import CustomerShow from '@components/customer/CustomerShow'

import Customer from '@classes/Customer'
const customerClass = new Customer();

const bools = {is_editable: true, is_deletable: true};
const getCustomerObj = {'id': 1, ...bools};
const getCustomerInvoicesArr = [{id:1,}, {id:2}];
const getCustomerPaymentsArr = [{id:10}, {id:20}];
const mockUpdatedCustomer = {id: 2, test: 'abc'}

customerClass.show = jest.fn().mockReturnValue({data: getCustomerObj});
customerClass.invoices = jest.fn().mockReturnValue({data: getCustomerInvoicesArr});
customerClass.payments = jest.fn().mockReturnValue({data: getCustomerPaymentsArr});
customerClass.update = jest.fn().mockReturnValue({data: {customer: mockUpdatedCustomer}});
customerClass.destroy = jest.fn();

const wrapper = shallowMount(CustomerShow, {
  propsData: {customerId: 1},
  // methods: {  },
  components: {
    'upload': jest.fn(),
  },
  data: function() {
    return {
      customerClass
    }
  }
});



describe('CustomerShow', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  test('calls for initial data load', () => {
    expect(wrapper.vm.customerClass.show).toBeCalled()
    expect(wrapper.vm.customerClass.invoices).toBeCalled()
  })


  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
      'customerClass', 
      'customer', 
      'invoices', 
      'payments',
      'customerIsReady',
      'invoicesAreReady',
      'paymentsAreReady',
      'customerBeingEdited'
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.customerClass ).toBeInstanceOf(Customer);
    expect( wrapper.vm.customer ).toEqual(getCustomerObj);
    expect( wrapper.vm.invoices ).toEqual(getCustomerInvoicesArr);
    expect( wrapper.vm.payments ).toEqual(getCustomerPaymentsArr);
    expect( wrapper.vm.customerIsReady ).toBeTruthy();
    expect( wrapper.vm.invoicesAreReady ).toBeTruthy();
    expect( wrapper.vm.paymentsAreReady ).toBeTruthy();
    expect( wrapper.vm.customerBeingEdited ).toBeNull();
  })





  // test('it calls for destroy when clicking the button', () => {
  //   const btn = wrapper.find('#destroyCustomer')
  //   window.alert = () => {};
  //   window.router = {
  //     go: jest.fn()
  //   }
  //   btn.trigger('click')
  //   expect(wrapper.vm.customerClass.destroy).toBeCalled();
  // })


  // test('edit button works correctly', async() => {
  //   const btnEdit = wrapper.find('#editCustomer');
  //   btnEdit.trigger('click');
  //   expect( wrapper.vm.customerBeingEdited).toEqual(getCustomerObj)
  // })

  // test('update button works correctly', async() => {
  //   window.alert = () => {};
  //   const btnUpdate = wrapper.find('#updateCustomer');

  //   btnUpdate.trigger('click');
    
  //   await expect(wrapper.vm.customerClass.update).toBeCalled();
  //   await expect( wrapper.vm.customerBeingEdited).toBeNull();
  //   await expect( wrapper.vm.customer).toEqual(mockUpdatedCustomer);
  // })

  // test('cancel button works correctly', async() => {
  //   const btnEdit = wrapper.find('#editCustomer');
  //   btnEdit.trigger('click');

  //   const btnCancel = wrapper.find('#cancelEditCustomer');
  //   btnCancel.trigger('click');
  //   expect( wrapper.vm.customerBeingEdited).toEqual(null)
  // });



})
