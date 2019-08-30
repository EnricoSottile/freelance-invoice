<template>
    <div>
        <div>Invoice show</div>

        <div>
            <pre>{{ invoice }}</pre>


            <button @click="destroyInvoice">Delete</button>
            <br/><br/><br/>
        </div>
    </div>
</template>

<script>
    import Invoice from '../../classes/Invoice'

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


        mounted(){
            this.getInvoice(this.invoiceId);
        },

        beforeRouteUpdate (to, from, next) {
            this.getInvoice(this.invoiceId);
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
            async destroyInvoice(){
                const response = await this.invoiceClass.destroy(this.invoiceId);
            }
        },




    }
</script>
