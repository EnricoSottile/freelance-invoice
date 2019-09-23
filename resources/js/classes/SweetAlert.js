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
    static async confirmRestore(resource, config = null){
        const defaults = {
            title: 'Are you sure?',
            text: `This ${resource} will be restored.`,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore it!',
            cancelButtonText: 'Nevermind',
            allowEscapeKey : false,
        };

        config = Object.assign({}, defaults, config);

        const result = await Swal.fire(config);

        if (result.value) {
            return true;
        }
        else if (result.dismiss === Swal.DismissReason.cancel) {
            return false;
        }
    }

  
    /**
     * 
     * @param {String} resource 
     */
    static async confirmDelete(resource, config = null){
        const defaults = {
            title: 'Are you sure?',
            text: `This ${resource} will be deleted.`,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
            allowEscapeKey : false,
        };

        config = Object.assign({}, defaults, config);

        const result = await Swal.fire(config);

        if (result.value) {
            return true;
        }
        else if (result.dismiss === Swal.DismissReason.cancel) {
            return false;
        }
    }


}

export default SweetAlert