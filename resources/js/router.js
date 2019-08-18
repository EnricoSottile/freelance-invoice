import VueRouter from 'vue-router'
Vue.use(VueRouter)

import CustomerIndex from './components/customer/CustomerIndex'
import CustomerShow from './components/customer/CustomerShow'


const routes = [

    // CUSTOMER
    { path: '/customer', component: CustomerIndex },
    { path: '/customer/:customer', component: CustomerShow },


    
]

window.router = new VueRouter({
    routes
})

