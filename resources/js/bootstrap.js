/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import SweetAlert from '@classes/SweetAlert'


window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// TODO: better handling of errors
window.axios.interceptors.response.use( response => response,  error => {

    if (error.response && error.response.status) {

        if (error.response.status === 404) {
            // missing resource
            if (error.response && error.response.data && error.response.data.message) {
                SweetAlert.fire('Are you lost?', error.response.data.message, 'error');
                // alert(error.response.data.message);
            }
            router.push('/home')
        } else if (error.response.status === 403) {
            // error in deleting/editing
            if (error.response && error.response.data && error.response.data.message) {
                SweetAlert.fire('You can\'t do that!', error.response.data.message, 'error');
            }
        } else if (error.response.status === 422) {
            // validation error            
            if (error.response && error.response.data && error.response.data.errors) {
                const errors = error.response.data.errors;
                const values = Object.values(errors);

                SweetAlert.fire('Thou shall not pass', values.join("\n"), 'error');
            }
        } else {
            alert("Unknown error");
        }



    }


    return Promise.reject(error);
  });

