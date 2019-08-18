window.Vue = require('vue');

require('./bootstrap');
require('./router.js');



const app = new Vue({
    el: '#app',

    router,

});
