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
                    @submit="updateInvoice"    
                    :isReady="invoiceIsReady"
                    :invoiceClass="invoiceClass"
                    :model="getInvoiceModel"
                    :isEdit="invoiceBeingEdited !== null">

                    <template v-slot:buttons>
                        <template  v-if="invoiceBeingEdited">
                            <button type="button" class="btn btn-default" id="cancelEditInvoice" @click="cancelEditInvoice">Cancel</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </template>
                        <template v-else>
                            <button type="button" v-if="isEditable" class="btn btn-default"  id="editInvoice" @click="editInvoice">Edit</button>
                        </template>  
                    </template>

                </invoice-form>                    
            </div>

            <!-- upload -->
            <div class="w-1/2">
                <upload 
                    resource-type="invoice" 
                    :resource-id="invoice.id" 
                    :allowUploads="true"
                    :allowDeletes="isDestroyable"
                    v-if="invoiceIsReady">
                </upload>
            </div>

            <div class="w-full mb-10" v-if="invoiceIsReady">
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
    import SweetAlert from '@classes/SweetAlert'
    import UiCommonMethods from '@mixins/UiCommonMethods'
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

        mixins: [ UiCommonMethods ],

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
            isEditable() {
                return this.invoice.is_editable;
            },
            isDestroyable() {
                return this.invoice.is_destroyable;
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
                const canDelete = await SweetAlert.confirmDelete('invoice');
                if (canDelete === false) return;

                const response = await this.invoiceClass.destroy(this.invoiceId);
                SweetAlert.fire('Deleted!', `The invoice has been deleted.`, 'success');
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
                SweetAlert.fire('Done!', `The invoice has been updated.`, 'success');
            },
            cancelEditInvoice(event, invoiceId) {
                this.invoiceBeingEdited = null;
            },
        },




    }
</script>

