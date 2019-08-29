import VueRouter from 'vue-router'
Vue.use(VueRouter)

import CustomerIndex from './components/customer/CustomerIndex'
import CustomerShow from './components/customer/CustomerShow'

import InvoiceIndex from './components/invoice/InvoiceIndex'
import InvoiceShow from './components/invoice/InvoiceShow'


const routes = [

    // CUSTOMER
    { path: '/customer', name: 'customer.index', component: CustomerIndex },
    { path: '/customer/:customer', name: 'customer.show', component: CustomerShow },

    // INVOICE
    { path: '/invoice', name: 'invoice.index', component: InvoiceIndex },
    { path: '/invoice/:invoice', name: 'invoice.show', component: InvoiceShow },

]

window.router = new VueRouter({
    routes
})

