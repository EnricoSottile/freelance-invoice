<template>
    <div>
        <div>Customer show</div>

        <div>
            <pre>{{ customer }}</pre>
        </div>

        <template v-if="customerIsReady">

            <invoice-index 
                v-if="invoicesAreReady" 
                :shouldHandleOwnLoading="false" 
                :filteredInvoices="invoices">
            </invoice-index>

        </template>

        
    </div>
</template>

<script>
    import Customer from '../../classes/Customer'
    import InvoiceIndex from '../invoice/InvoiceIndex'

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
            'invoice-index': InvoiceIndex
        },


        mounted(){
            this.getCustomer(this.customerId);
            this.getCustomerInvoices(this.customerId);
        }, 

        beforeRouteUpdate (to, from, next) {
            this.getCustomer(this.customerId);
            this.getCustomerInvoices(this.customerId);

            next();
        },


        data(){
            return {
                customerClass: new Customer(),
                customer: {},
                invoices: [],
                customerIsReady: false,
                invoicesAreReady: false,
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
                console.log(data);
                this.invoices = data;
                this.invoicesAreReady = true;
            },
        },




    }
</script>
