<template>
    <div class="card">

        <div class="card-title">
            <h1>
                Payment {{ payment.id }} of {{ formatDate({}, payment.created_at) }}
            </h1>
            <small>Last update: {{ formatDate({}, payment.updated_at) }}</small>
        </div>


        <div class="flex mt-10">

            <!-- payment -->
            <div class="w-1/2">
                <div v-if="paymentBeingEdited">
                    <select v-model="paymentBeingEdited.invoice_id">
                        <option default selected value="">Choose an invoice</option>
                        <option 
                            v-bind:key="invoice.id" 
                            v-for="invoice in invoices" 
                            :value="invoice.id">
                            {{ invoice.number }}
                            </option>
                    </select>
                    {{ paymentBeingEdited.invoice_id }}
                    <br/>
                    <input v-model="paymentBeingEdited.net_amount" name="net_amount" placeholder="Net amount" type="number"/><br/>
                    <input v-model="paymentBeingEdited.due_date" name="due_date" placeholder="Due date" type="date"/><br/>
                    <input v-model="paymentBeingEdited.payed_date" name="payed_date" placeholder="Payed date" type="date"/><br/>
                    <button id="updatePayment" @click="updatePayment">Update</button>
                    <button id="cancelEditPayment" @click="cancelEditPayment">Cancel</button>
                </div>
                <div v-else>
                    <pre>{{ payment }}</pre>


                    <button v-if="isEditable"  id="editPayment" @click="editPayment">Edit</button>
                    <button v-if="isDestroyable"  id="destroyPayment" @click="destroyPayment">Delete</button>
                    <br/><br/><br/>
                </div>  
            </div>

            <!-- upload -->
            <div class="w-1/2">
                <upload 
                    resource-type="payment" 
                    :resource-id="payment.id" 
                    :allowUploads="isEditable"
                    :allowDeletes="isDestroyable"
                    v-if="paymentIsReady">
                </upload>
            </div>
        </div>







    </div>
</template>

<script>
    import Payment from '@classes/Payment'
    import Upload from '@components/shared/Upload'
    import _formatDate from '@helpers/formatDate'

    export default {
        props: {
            paymentId: {
                required: true,
                type: [String, Number]
            },
        },

        components: {
            'upload': Upload
        },


        created(){
            this.getPayment(this.paymentId);
            this.getInvoices();
        },

        beforeRouteUpdate (to, from, next) {
            const paymentId = to.params.paymentId;
            this.getPayment(paymentId);
            this.getInvoices();
            next();
        },


        data(){
            return {
                paymentClass: Payment,
                payment: {},
                invoice: [],
                paymentIsReady: false,
                invoicesAreReady: false,
                paymentBeingEdited: null,
            }
        },

        computed: {
            isEditable() {
                return this.payment.payed_date === null;
            },
            isDestroyable() {
                return this.payment.payed_date === null;
            }
        },

        methods: {
            async getPayment(paymentId){
                const { data } = await this.paymentClass.show(paymentId);
                this.payment = data;
                this.paymentIsReady = true;
            },
            async getInvoices(){
                const { data } = await this.paymentClass.invoices();
                this.invoices = data;
                this.invoicesAreReady = true;
            },
            async destroyPayment(){
                const response = await this.paymentClass.destroy(this.paymentId);
                alert("payment was deleted");
                router.go(-1)
            },
            editPayment(){
                const paymentBeingEdited = { ...this.payment};
                this.paymentBeingEdited = paymentBeingEdited;
            },
            async updatePayment(){
                const {data: {payment}} = await this.paymentClass.update(this.payment.id, this.paymentBeingEdited);
                this.paymentBeingEdited = null;
                this.payment = {...payment};
                alert('payment was updated');
            },
            cancelEditPayment(event, paymentId) {
                this.paymentBeingEdited = null;
            },

            formatDate(options, value) {
                return _formatDate(options, value)
            },
        },




    }
</script>

