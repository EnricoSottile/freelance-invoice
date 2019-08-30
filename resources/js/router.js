import VueRouter from 'vue-router'
Vue.use(VueRouter)

import CustomerIndex from './components/customer/CustomerIndex'
import CustomerShow from './components/customer/CustomerShow'

import InvoiceIndex from './components/invoice/InvoiceIndex'
import InvoiceShow from './components/invoice/InvoiceShow'


const routes = [

    // CUSTOMER
    { path: '/customer', name: 'customer.index', component: CustomerIndex },
    { 
        path: '/customer/:customerId', 
        name: 'customer.show', 
        component: CustomerShow, props: true 
    },

    // INVOICE
    { 
        path: '/invoice', 
        name: 'invoice.index', 
        component: InvoiceIndex,
        props: {shouldHandleOwnLoading: true}
    },
    { 
        path: '/invoice/:invoiceId', 
        name: 'invoice.show', 
        component: InvoiceShow, 
        props: true
    },

]

window.router = new VueRouter({
    routes
})

