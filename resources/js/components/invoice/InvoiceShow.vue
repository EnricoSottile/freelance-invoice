<template>
    <div>


        <div class="card-title">
            <h1>
                Invoice {{ invoice.id }} of {{ formatDate({}, invoice.created_at) }}

                <button 
                    v-if="isDestroyable"
                    id="destroyInvoice"
                    @click="destroyInvoice"
                    class="btn btn-xs btn-danger btn-circle text-xl inline-block">
                    <span v-html="getIcon('trash')" class="flex justify-center align-middle"></span>
                </button>

                <label v-if="!isDestroyable" class="inline-block">
                    <span v-html="getIcon('lock')" class="flex justify-center align-middle text-gray-500"></span>
                </label>

                
            </h1>
            <small>Last update: {{ formatDate({}, invoice.updated_at) }}</small>

        </div>


        <div class="flex flex-wrap mt-10">

            <!-- invoice -->
            <div class="w-1/2">
                <invoice-form
                    :isReady="invoiceIsReady"
                    :invoiceClass="invoiceClass"
                    :model="getInvoiceModel"
                    :isEdit="invoiceBeingEdited !== null">

                    <template v-slot:buttons>
                        <template  v-if="invoiceBeingEdited">
                            <button class="btn btn-default" id="cancelEditInvoice" @click="cancelEditInvoice">Cancel</button>
                            <button class="btn btn-success" id="updateInvoice" @click="updateInvoice">Update</button>
                        </template>
                        <template v-else>
                            <button v-if="isEditable" class="btn btn-default"  id="editInvoice" @click="editInvoice">Edit</button>
                        </template>  
                    </template>

                </invoice-form>                    
            </div>

            <!-- upload -->
            <div class="w-1/2">
                <upload 
                    resource-type="invoice" 
                    :resource-id="invoice.id" 
                    :allowUploads="isEditable"
                    :allowDeletes="isDestroyable"
                    v-if="invoiceIsReady">
                </upload>
            </div>

            <div class="w-full" v-if="invoiceIsReady">
                <payment-index 
                    v-if="paymentsAreReady" 
                    :shouldHandleOwnLoading="false" 
                    :invoice="invoice"
                    :filteredPayments="payments"
                    :hiddenFields="['invoice_number', 'created']">
                </payment-index>
            </div>


        </div>



    </div>
</template>

<script>
    import _getIcon from '@helpers/getIcon'
    import _formatDate from '@helpers/formatDate'

    import Invoice from '@classes/Invoice'
    import InvoiceForm from '@components/invoice/shared/InvoiceForm'
    import PaymentIndex from '@components/payment/Index/PaymentIndex'
    import Upload from '@components/shared/Upload/Upload'


    export default {
        props: {
            invoiceId: {
                required: true,
                type: [String, Number]
            },
        },

        components: {
            'payment-index': PaymentIndex,
            'invoice-form': InvoiceForm,
            'upload': Upload
        },


        created(){
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
                invoiceClass: Invoice,
                invoice: {},
                payments: [],
                invoiceIsReady: false,
                paymentsAreReady: false,
                invoiceBeingEdited: null,

            }
        },

        computed: {
            getInvoiceModel(){
                return this.invoiceBeingEdited ? this.invoiceBeingEdited : this.invoice;
            },
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
            },

            formatDate(options, value) {
                return _formatDate(options, value)
            },
            getIcon(icon) {
                return _getIcon(icon);
            }
        },




    }
</script>

