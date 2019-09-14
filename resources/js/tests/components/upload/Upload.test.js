import { shallowMount } from '@vue/test-utils'
import Upload from '@components/upload/Upload'
import UploadClass from '@classes/Upload'


window.axios = {};
window.axios.get = jest.fn().mockReturnValue({ data: {uploads: []} });

const wrapper = shallowMount(Upload, {
    propsData: {
        resourceType: 'invoice',
        resourceId: 1,
        allowUploads: true,
        allowDeletes: true,
    },
  data: function() {
    return {
    }
  }
});


wrapper.vm.uploadClass.store = jest.fn().mockReturnValue({ data: {upload: {id:1}} });
wrapper.vm.uploadClass.destroy = jest.fn();



describe('Upload', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })



  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
        'uploadClass',
        'imageSrc',
        'upload',
        'uploads',
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.uploadClass ).toBeInstanceOf(UploadClass);
    expect( wrapper.vm.imageSrc ).toEqual('');
    expect( wrapper.vm.upload ).toEqual('');
    expect( wrapper.vm.uploads ).toEqual([]);
  })

 
  test('it calls for store when clicking the button', () => {
    wrapper.vm.imageSrc = 'abc';
    const btn = wrapper.find('#uploadImage')
    window.alert = () => {};
    btn.trigger('click')
    expect(wrapper.vm.uploadClass.store).toBeCalled();
  })


  test('it removes the image when clicking the button', () => {
    wrapper.vm.imageSrc = 'abc';
    const btn = wrapper.find('#removeImage')
    btn.trigger('click')
    expect(wrapper.vm.imageSrc).toEqual('');
  })


    
  test('it calls for destroy when clicking the button', () => {
      wrapper.vm.uploads = [{id:1}, {id:2}]
    const btn = wrapper.find('#destroyUpload')
    window.alert = () => {};
    btn.trigger('click')
    expect(wrapper.vm.uploadClass.destroy).toBeCalled();
  })



})
