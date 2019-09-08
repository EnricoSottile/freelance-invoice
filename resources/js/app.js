window.Vue = require('vue');

require('./bootstrap');
require('./router.js');

import Navbar from './components/shared/Navbar'

const app = new Vue({
    el: '#app',

    router,

    components: {
        'nav-bar': Navbar,
    },

});
