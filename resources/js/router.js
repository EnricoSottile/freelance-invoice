import VueRouter from 'vue-router'
Vue.use(VueRouter)

import CustomerIndex from './components/customer/Index/CustomerIndex'
import CustomerShow from './components/customer/CustomerShow'
import CustomerCreate from './components/customer/CustomerCreate'

import InvoiceIndex from './components/invoice/Index/InvoiceIndex'
import InvoiceCreate from './components/invoice/InvoiceCreate'
import InvoiceShow from './components/invoice/InvoiceShow'

import PaymentIndex from './components/payment/Index/PaymentIndex'
import PaymentShow from './components/payment/PaymentShow'
import PaymentCreate from './components/payment/PaymentCreate'

import TrashIndex from './components/trash/Index/TrashIndex'
import TrashShow from './components/trash/TrashShow'

const routes = [

    { path: '/', name: 'dashboard' },

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
    },
    { 
        path: '/payment/create', 
        name: 'payment.create', 
        component: PaymentCreate, 
    },
    { 
        path: '/invoice/:invoiceId/payment/create', 
        name: 'invoice.payment.create', 
        component: PaymentCreate, 
        props: true
    },
    { 
        path: '/payment/:paymentId', 
        name: 'payment.show', 
        component: PaymentShow, 
        props: true
    },


    // PAYMENT
    { 
        path: '/trash', 
        name: 'trash.index', 
        component: TrashIndex,
    },
    { 
        path: '/trash/:resource/:trashedId', 
        name: 'trash.show', 
        component: TrashShow, 
        props: true
    },


]

window.router = new VueRouter({
    routes
})



