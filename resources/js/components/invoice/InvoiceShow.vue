<template>
    <div>
        <div>Invoice show</div>

        <div>
            <pre>{{ invoice }}</pre>


            <button id="destroyInvoice" @click="destroyInvoice">Delete</button>
            <br/><br/><br/>
        </div>  

        <template v-if="invoiceIsReady">

            <payment-index 
                v-if="paymentsAreReady" 
                :shouldHandleOwnLoading="false" 
                :invoice="invoice"
                :filteredPayments="payments">
            </payment-index>

        </template>

    </div>
</template>

<script>
    import Invoice from '../../classes/Invoice'
    import PaymentIndex from '../payment/PaymentIndex'


    export default {
        props: {
            invoiceId: {
                required: true,
                validator(value) {
                    const type = typeof(value);
                    return type === 'string' || type === 'number';
                }
            },
        },

        components: {
            'payment-index': PaymentIndex
        },


        mounted(){
            this.getInvoice(this.invoiceId);
            this.getInvoicePayments(this.invoiceId);
        },

        beforeRouteUpdate (to, from, next) {
            this.getInvoice(this.invoiceId);
            this.getInvoicePayments(this.invoiceId);
            next();
        },


        data(){
            return {
                invoiceClass: new Invoice(),
                invoice: {},
                payments: [],
                invoiceIsReady: false,
                paymentsAreReady: false,
            }
        },

        methods: {
            async getInvoice(invoiceId){
                const { data } = await this.invoiceClass.show(invoiceId);
                this.invoice = data;
                this.invoiceIsReady = true;
            },
            async getInvoicePayments(invoiceId){
                const { data } = await this.invoiceClass.payments(invoiceId);
                this.payments = data;
                this.paymentsAreReady = true;
            },
            async destroyInvoice(){
                const response = await this.invoiceClass.destroy(this.invoiceId);
                alert("invoice was deleted");
                router.go(-1)
            },

        },




    }
</script>

