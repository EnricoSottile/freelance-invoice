<template>
    <div>
        <div>Invoice show</div>

        <div v-if="invoiceBeingEdited">
            <input v-model="invoiceBeingEdited.customer_id" name="customer_id" placeholder="Customer id" type="number"/><br/>
            <input v-model="invoiceBeingEdited.number" name="number" placeholder="Number" type="number"/><br/>
            <input v-model="invoiceBeingEdited.net_amount" name="net_amount" placeholder="Net amount" type="number"/><br/>
            <input v-model="invoiceBeingEdited.tax" name="tax" placeholder="Tax" type="number"/><br/>
            <input v-model="invoiceBeingEdited.description" name="description" placeholder="Description" type="text"/><br/>
            <input v-model="invoiceBeingEdited.date" name="date" placeholder="Date" type="date"/><br/>
            <input v-model="invoiceBeingEdited.sent_date" name="sent_date" placeholder="Sent date" type="date"/><br/>
            <input v-model="invoiceBeingEdited.registered_date" name="registered_date" placeholder="Registered date" type="date"/><br/>
            <button id="updateInvoice" @click="updateInvoice">Update</button>
            <button id="cancelEditInvoice" @click="cancelEditInvoice">Cancel</button>
        </div>
        <div v-else>
            <pre>{{ invoice }}</pre>


            <button v-if="isEditable"  id="editInvoice" @click="editInvoice">Edit</button>
            <button v-if="isDestroyable"  id="destroyInvoice" @click="destroyInvoice">Delete</button>
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
            const invoiceId = to.params.invoiceId;
            this.getInvoice(invoiceId);
            this.getInvoicePayments(invoiceId);
            next();
        },


        data(){
            return {
                invoiceClass: new Invoice(),
                invoice: {},
                payments: [],
                invoiceIsReady: false,
                paymentsAreReady: false,
                invoiceBeingEdited: null,

            }
        },

        computed: {
            hasPayedPayments(){
                return this.payments 
                && this.payments.filter(p => p.payed_date).length;
            },
            isEditable() {
                return this.invoice.registered_date === null
                && this.hasPayedPayments === 0;
            },
            isDestroyable() {
                return this.invoice.registered_date === null
                && this.hasPayedPayments === 0;
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
            editInvoice(){
                const invoiceBeingEdited = { ...this.invoice};
                this.invoiceBeingEdited = invoiceBeingEdited;
            },
            async updateInvoice(){
                const {data: {invoice}} = await this.invoiceClass.update(this.invoice.id, this.invoiceBeingEdited);
                this.invoiceBeingEdited = null;
                this.invoice = {...invoice};
                alert('invoice was updated');
            },
            cancelEditInvoice(event, invoiceId) {
                this.invoiceBeingEdited = null;
            }

        },




    }
</script>

