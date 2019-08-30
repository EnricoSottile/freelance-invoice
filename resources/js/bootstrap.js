/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */



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
                alert(error.response.data.message);
            }
            router.push('/home')
        }


        if (error.response.status === 403) {
            // error in deleting
            if (error.response && error.response.data && error.response.data.message) {
                alert(error.response.data.message);
            }
        }

    }


    return Promise.reject(error);
  });

