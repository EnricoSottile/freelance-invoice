import { shallowMount } from '@vue/test-utils'
import Upload from '@components/shared/Upload/Upload'
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


wrapper.vm.uploadClass.destroy = jest.fn();



describe('Upload', () => {

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })



  test('initial data params are correct', () => {
    const data = wrapper.vm._data;
    const expectedData = [
        'galleryIsReady',
        'uploadClass',
        'existingUploads',
    ];

    expect( Object.keys(data).sort() ).toEqual(expectedData.sort());

    expect( wrapper.vm.uploadClass ).toBeInstanceOf(UploadClass);
    expect( wrapper.vm.existingUploads ).toEqual([]);
  })





})
