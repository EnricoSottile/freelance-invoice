import { shallowMount } from '@vue/test-utils'
import CustomerCreate from '../../../components/customer/CustomerCreate'
import Customer from '../../../classes/Customer'

const customerClass = jest.fn();


const mockCreate = {
    full_name: null,
    email: null,
    phone: null,
    vat_code: null
}
const mockCustomer = {
    full_name: 'testabc',
    email: 'test@test.test',
    phone: 1234,
    vat_code: 5678
};


const stubReturnStoredCustomer = jest.fn().mockReturnValue({data: {customer: mockCustomer}});

customerClass.store = stubReturnStoredCustomer
customerClass.create = jest.fn().mockReturnValue(mockCreate);

const mockData = [{id:1}, {id:2}]
customerClass.customers = jest.fn().mockReturnValue({data: mockData});



const wrapper = shallowMount(CustomerCreate,{
  data: function() {
    return {
      customerClass
    }
  }
});



describe('CustomerCreate', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })


  test('initial data params are correct', async () => {
    const data = wrapper.vm._data;
    const expectedData = [
        'customerClass', 'customer'
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());
    // expect( wrapper.vm.customerClass ).toBeInstanceOf(Customer);
    expect( wrapper.vm.customer ).toEqual(mockCreate);
  })



  test('save button works correctly', async() => {
    window.alert = () => {};
    window.router = {
      push: () => {},
    };

    
    const btnSave = wrapper.find('#saveNewCustomer');
    btnSave.trigger('click');
    await expect(wrapper.vm.customerClass.store).toBeCalled();
  })  



})
  