<template>
    <div>

        <div>Payment create</div>

            <div v-if="invoicesAreReady">
            <select :disabled="invoiceId !== null" v-model="payment.invoice_id">
                <option default selected value="">Choose an invoice</option>
                <option 
                    v-bind:key="invoice.id" 
                    v-for="invoice in invoices" 
                    :value="invoice.id">
                    {{ invoice.number }}
                    </option>
            </select>
            {{ payment.invoice_id }}
            <br/>
            <input v-model="payment.net_amount" name="net_amount" placeholder="Net amount" type="number"/><br/>
            <input v-model="payment.due_date" name="due_date" placeholder="Due date" type="date"/><br/>
            <input v-model="payment.payed_date" name="payed_date" placeholder="Payed date" type="date"/><br/>
            <button id="saveNewPayment" @click="saveNewPayment">Save</button>
        </div>
        <p v-else>
            loading
        </p>


    </div>
</template>

<script>    
    import Payment from '@classes/Payment'


    export default {

        props: {
            invoiceId: {
                required: false,
                default: null,
                type: [String, Number]
            },
        },


        created(){
            this.payment = this.paymentClass.create();
            this.setInvoice(this.invoiceId);
            this.getInvoices();
        },

        beforeRouteUpdate (to, from, next) {            
            const invoiceId = to.params.invoiceId;
            this.payment = this.paymentClass.create();
            this.setInvoice(invoiceId);
            this.getInvoices();
            next();
        },

        data(){
            return {
                paymentClass: Payment,
                payment: {},
                invoices: [],
                invoicesAreReady: false
            }
        },



        methods: {
            async saveNewPayment(){
                const {data: {payment}} = await this.paymentClass.store(this.payment);
                alert('payment was added');
                router.push({ name: 'payment.show', params: { paymentId: payment.id } })
            },
            async getInvoices(){
                const { data } = await this.paymentClass.invoices();
                this.invoices = data;
                this.invoicesAreReady = true;
            },
            setInvoice(invoiceId){
                if (invoiceId === null) return;
                this.payment.invoice_id = invoiceId;
            }
        },
    }
</script>
