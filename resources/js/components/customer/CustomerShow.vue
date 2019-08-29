<template>
    <div>
        <div>Customer show</div>

        <div>
            <pre>{{ customer }}</pre>
        </div>

        <invoice-index></invoice-index>
    </div>
</template>

<script>
    import Customer from '../../classes/Customer'
    import InvoiceIndex from '../invoice/InvoiceIndex'

    export default {
        components: {
            'invoice-index': InvoiceIndex
        },


        mounted(){
            this.getCustomer(this.$route.params.customer);
        },

        beforeRouteUpdate (to, from, next) {
            this.getCustomer(to.params.customer);
            next();
        },


        data(){
            return {
                customerClass: new Customer(),
                customer: {},
            }
        },

        methods: {
            async getCustomer(customerId){
                const { data } = await this.customerClass.show(customerId);
                this.customer = data;
            },
        },




    }
</script>
