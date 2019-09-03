<template>
    <div>
        <div>Customer show</div>

        <div>
            <pre>{{ customer }}</pre>

            <button id="destroyCustomer" @click="destroyCustomer">Delete</button>
            <br/><br/><br/>
        </div>

        <div v-if="customerIsReady" style="display:flex">

            <div>
                <invoice-index 
                    v-if="invoicesAreReady" 
                    :shouldHandleOwnLoading="false" 
                    :filteredInvoices="invoices"
                    :customer="customer">
                </invoice-index>
            </div>

            <div v-if="paymentsAreReady">
                <payment-index 
                    v-if="paymentsAreReady" 
                    :shouldHandleOwnLoading="false" 
                    :filteredPayments="payments">
                </payment-index>
            </div>

        </div>



        
    </div>
</template>

<script>
    import Customer from '../../classes/Customer'
    import InvoiceIndex from '../invoice/InvoiceIndex'
    import PaymentIndex from '../payment/PaymentIndex'


    export default {
        props: {
            customerId: {
                required: true,
                validator(value) {
                    const type = typeof(value);
                    return type === 'string' || type === 'number';
                }
            },
        },

        components: {
            'invoice-index': InvoiceIndex,
            'payment-index': PaymentIndex
        },


        mounted(){
            this.getCustomer(this.customerId);
            this.getCustomerInvoices(this.customerId);
            this.getCustomerPayments(this.customerId);
        }, 

        beforeRouteUpdate (to, from, next) {
            this.getCustomer(this.customerId);
            this.getCustomerInvoices(this.customerId);
            this.getCustomerPayments(this.customerId);

            next();
        },


        data(){
            return {
                customerClass: new Customer(),
                customer: {},
                invoices: [],
                payments: [],
                customerIsReady: false,
                invoicesAreReady: false,
                paymentsAreReady: false
            }
        },

        computed: {
            hasPayedPayments(){
                return this.payments 
                && this.payments.filter(p => p.payed_date).length;
            },
            hasRegisteredInvoices(){
                return this.invoices 
                && this.invoices.filter(i => i.registered_date).length;
            },
            isEditable() {
                return this.hasPayedPayments === 0 
                && this.hasRegisteredInvoices === 0
            },
            isDestroyable() {
                return this.hasPayedPayments === 0 
                && this.hasRegisteredInvoices === 0
            }
        },

        methods: {
            async getCustomer(customerId){
                const { data } = await this.customerClass.show(customerId);
                this.customer = data;
                this.customerIsReady = true;
            },
            async getCustomerInvoices(customerId){
                const { data } = await this.customerClass.invoices(customerId);
                this.invoices = data;
                this.invoicesAreReady = true;
            },
            async getCustomerPayments(customerId){
                const { data } = await this.customerClass.payments(customerId);
                this.payments = data;
                this.paymentsAreReady = true;
            },
            async destroyCustomer(){
                const response = await this.customerClass.destroy(this.customerId);
                window.alert("customer was deleted");
                router.go(-1)
            }
        },




    }
</script>
