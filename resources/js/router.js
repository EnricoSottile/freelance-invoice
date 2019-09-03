import VueRouter from 'vue-router'
Vue.use(VueRouter)

import CustomerIndex from './components/customer/CustomerIndex'
import CustomerShow from './components/customer/CustomerShow'
import CustomerCreate from './components/customer/CustomerCreate'

import InvoiceIndex from './components/invoice/InvoiceIndex'
import InvoiceCreate from './components/invoice/InvoiceCreate'
import InvoiceShow from './components/invoice/InvoiceShow'

import PaymentIndex from './components/payment/PaymentIndex'

const routes = [


    // CUSTOMER
    { path: '/customer', name: 'customer.index', component: CustomerIndex },
    { 
        path: '/customer/create', 
        name: 'customer.create', 
        component: CustomerCreate, 
    },
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
        path: '/invoice/create', 
        name: 'invoice.create', 
        component: InvoiceCreate, 
    },
    { 
        path: '/customer/:customerId/invoice/create', 
        name: 'customer.invoice.create', 
        component: InvoiceCreate, 
        props: true
    },
    { 
        path: '/invoice/:invoiceId', 
        name: 'invoice.show', 
        component: InvoiceShow, 
        props: true
    },


    // PAYMENT
    { 
        path: '/payment', 
        name: 'payment.index', 
        component: PaymentIndex,
        props: {shouldHandleOwnLoading: true}
    }

]

window.router = new VueRouter({
    routes
})



