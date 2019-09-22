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

    if (error.response.status) {

        switch(error.response.status) {
            case 500:
                SweetAlert.fire('Unexpected problem', 'Something did not work', 'error');
                break;
            case 422: 
                const errors = error.response.data.errors;
                const values = Object.values(errors);
                SweetAlert.fire('Thou shall not pass', values.join("\n"), 'error');
                break;
            case 419:
                SweetAlert.fire('Try to reload the page', error.response.data.message, 'error');
                break;
            case 404:
                SweetAlert.fire('Are you lost?', error.response.data.message, 'error');
                break;
            case 403:
                SweetAlert.fire('You can\'t do that!', error.response.data.message, 'error');
                break;
            default:
                SweetAlert.fire('Unknown error', 'An unhandled error just happened', 'error');
                break;
        }

    }


    return Promise.reject(error);
  });

