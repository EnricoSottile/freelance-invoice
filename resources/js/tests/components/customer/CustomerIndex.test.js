import { shallowMount } from '@vue/test-utils'
import CustomerIndex from '@components/customer/Index/CustomerIndex'

import Customer from '@classes/Customer'
const customerClass = new Customer();

const getCustomersObj = [{id:1}, {id:2}];
customerClass.index = jest.fn().mockReturnValue({data: getCustomersObj});

const wrapper = shallowMount(CustomerIndex, {
  // methods: {  },
  stubs: ['router-link'],
  data: function() {
    return {
      customerClass
    }
  }
});




describe('CustomerIndex', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  test('calls for initial data load', () => {
    expect(wrapper.vm.customerClass.index).toBeCalled()
  })


  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
      'customerClass', 
      'customers', 
      'customersAreReady',
      'fields'
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.customerClass ).toBeInstanceOf(Customer);
    expect( wrapper.vm.customers ).toEqual(getCustomersObj);
  })


})
