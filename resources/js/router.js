import VueRouter from 'vue-router'
Vue.use(VueRouter)

import CustomerIndex from './components/customer/CustomerIndex'
import CustomerShow from './components/customer/CustomerShow'


const routes = [

    // CUSTOMER
    { path: '/customer', name: 'customer.index', component: CustomerIndex },
    { path: '/customer/:customer', name: 'customer.show', component: CustomerShow },



]

window.router = new VueRouter({
    routes
})

