<template>
    <div>

        <div>Invoice create</div>

        <input v-model="invoice.customer_id" name="customer_id" placeholder="Customer id" type="number"/><br/>
        <input v-model="invoice.number" name="number" placeholder="Number" type="number"/><br/>
        <input v-model="invoice.net_amount" name="net_amount" placeholder="Net amount" type="number"/><br/>
        <input v-model="invoice.tax" name="tax" placeholder="Tax" type="number"/><br/>
        <input v-model="invoice.description" name="description" placeholder="Description" type="text"/><br/>
        <input v-model="invoice.date" name="date" placeholder="Date" type="date"/><br/>
        <input v-model="invoice.sent_date" name="sent_date" placeholder="Sent date" type="date"/><br/>
        <input v-model="invoice.registered_date" name="registered_date" placeholder="Registered date" type="date"/><br/>
        <button id="saveNewInvoice" @click="saveNewInvoice">Save</button>

    </div>
</template>

<script>    
    import Invoice from '../../classes/Invoice'


    export default {

        mounted(){
            this.invoice = this.invoiceClass.create();
        },

        beforeRouteUpdate (to, from, next) {
            this.invoice = this.invoiceClass.create();
            next();
        },

        data(){
            return {
                invoiceClass: new Invoice(),
                invoice: {}
            }
        },


        methods: {

            async saveNewInvoice(){
                const {data: {invoice}} = await this.invoiceClass.store(this.invoice);
                alert('invoice was added');
                router.push({ name: 'invoice.show', params: { invoiceId: invoice.id } })
            }
        },
    }
</script>
