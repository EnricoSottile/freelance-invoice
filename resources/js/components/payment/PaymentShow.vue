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
            <div class="w-1/2" v-if="paymentIsReady && invoicesAreReady">
                <div class="pr-6 flex flex-wrap">

                    <div class="mb-6 w-1/2 px-2">
                        <label class="label-default">
                            Invoice
                        </label>

                        <custom-select 
                            :disabled="!paymentBeingEdited"
                            v-model="getPaymentModel.invoice_id">
                                <option default selected value="">Choose an invoice</option>
                                <option 
                                    v-bind:key="invoice.id" 
                                    v-for="invoice in invoices" 
                                    :value="invoice.id">
                                    {{ invoice.number }}
                                </option>
                        </custom-select>
                    </div>

                    <div class="mb-6 w-1/2 px-2">
                        <label class="label-default">
                            Net amount
                        </label>
                        <input class="input-default" 
                            :readonly="!paymentBeingEdited"
                            v-model="getPaymentModel.net_amount" 
                            name="net_amount" 
                            placeholder="Net amount" 
                            type="number"/>
                    </div>

                    <div class="mb-6 w-1/2 px-2">
                        <label class="label-default">
                            Due date
                        </label>

                        <input class="input-default"
                            :readonly="!paymentBeingEdited" 
                            v-model="getPaymentModel.due_date" 
                            name="due_date" 
                            placeholder="Due date" 
                            type="date"/>
                    </div>

                    <div class="mb-6 w-1/2 px-2">
                        <label class="label-default">
                            Payed date
                        </label>

                        <input class="input-default" 
                            :readonly="!paymentBeingEdited"
                            v-model="getPaymentModel.payed_date" 
                            name="payed_date" 
                            placeholder="Payed date" 
                            type="date"/>
                    </div>

                    <div class="mb-6 w-1/2 px-2">
                        <template  v-if="paymentBeingEdited">
                            <button class="btn btn-default" id="cancelEditPayment" @click="cancelEditPayment">Cancel</button>
                            <button class="btn btn-success" id="updatePayment" @click="updatePayment">Update</button>
                        </template>
                        <template v-else>
                            <button v-if="isEditable" class="btn btn-default"  id="editPayment" @click="editPayment">Edit</button>
                            <button v-if="isDestroyable" class="btn btn-danger"  id="destroyPayment" @click="destroyPayment">Delete</button>
                        </template>                        
                    </div>

                    
                    
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
    import Select from '@components/shared/Select'
    import Payment from '@classes/Payment'
    import Upload from '@components/shared/Upload/Upload'
    import _formatDate from '@helpers/formatDate'

    export default {
        props: {
            paymentId: {
                required: true,
                type: [String, Number]
            },
        },

        components: {
            'custom-select': Select,
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
            getPaymentModel(){
                return this.paymentBeingEdited ? this.paymentBeingEdited : this.payment;
            },
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

