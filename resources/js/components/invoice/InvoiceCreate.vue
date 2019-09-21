<template>
    <div>

        <div class="card-title">
            <h1>
                Create new invoice                
            </h1>
        </div>

        <div class="flex mt-10">
            <div class="w-1/2">
                <invoice-form
                    :invoiceClass="invoiceClass"
                    :model="invoice"
                    :isEdit="true">

                    <template v-slot:buttons>
                        <button class="btn btn-success" id="saveNewInvoice" @click="saveNewInvoice">Save</button>
                    </template>

                </invoice-form>  
            </div>
        </div>

    </div>
</template>

<script>    
    import SweetAlert from '@classes/SweetAlert'

    import Invoice from '@classes/Invoice'
    import InvoiceForm from '@components/invoice/shared/InvoiceForm'


    export default {

        props: {
            customerId: {
                required: false,
                default: null,
                type: [String, Number]
            },
        },

        components: {
            'invoice-form': InvoiceForm
        },

        created(){
            this.invoice = this.invoiceClass.create();
            this.setCustomer(this.customerId);
        },

        beforeRouteUpdate (to, from, next) {
            const customerId = to.params.customerId;
            this.invoice = this.invoiceClass.create();
            this.setCustomer(customerId);
            next();
        },

        data(){
            return {
                invoiceClass: Invoice,
                invoice: {},
                customers: [],
                customersAreReady: false
            }
        },

        methods: {
            async saveNewInvoice(){
                const {data: {invoice}} = await this.invoiceClass.store(this.invoice);
                SweetAlert.fire('Done!', `The invoice has been created.`, 'success');
                router.push({ name: 'invoice.show', params: { invoiceId: invoice.id } })
            },
            setCustomer(customerId){
                if (customerId === null) return;
                this.invoice.customer_id = customerId;
            }
        },
    }
</script>
