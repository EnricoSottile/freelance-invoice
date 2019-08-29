<template>
    <div>
        <div>Invoice show</div>

        <div>
            <pre>{{ invoice }}</pre>
        </div>
    </div>
</template>

<script>
    import Invoice from '../../classes/Invoice'

    export default {


        mounted(){
            this.getInvoice(this.$route.params.invoice);
        },

        beforeRouteUpdate (to, from, next) {
            this.getInvoice(to.params.invoice);
            next();
        },


        data(){
            return {
                invoiceClass: new Invoice(),
                invoice: {},
            }
        },

        methods: {
            async getInvoice(invoiceId){
                const { data } = await this.invoiceClass.show(invoiceId);
                this.invoice = data;
            },
        },




    }
</script>
