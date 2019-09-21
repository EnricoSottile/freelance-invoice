import Swal from 'sweetalert2'

/**
 * Helper wrapper around the great sweetalert2
 */
class SweetAlert {
    
    /**
     * interface function to avoid 
     * importing Swal in other components
     * 
     */
    static fire(...args) {
        Swal.fire(...args);
    }

  
    /**
     * 
     * @param {String} resource 
     */
    static async confirmDelete(resource, text = null){
        const result = await Swal.fire({
            title: 'Are you sure?',
            text: text || `You will not be able to recover this ${resource}!`,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        });

        if (result.value) {
            return true;
        }
        else if (result.dismiss === Swal.DismissReason.cancel) {
            return false;
        }
    }


}

export default SweetAlert