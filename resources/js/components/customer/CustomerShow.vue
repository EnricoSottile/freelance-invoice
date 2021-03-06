<template>
    <div>

        <div class="card-title">
            <h1>
                Customer {{ customer.full_name }}

                <button 
                    v-if="isDestroyable"
                    id="destroyCustomer"
                    @click="destroyCustomer"
                    class="btn btn-xs btn-danger btn-circle text-xl inline-block">
                    <span v-html="getIcon('trash')" class="flex justify-center align-middle"></span>
                </button>

                <label v-if="!isDestroyable" class="inline-block">
                    <span v-html="getIcon('lock')" class="flex justify-center align-middle text-gray-500"></span>
                </label>

                
            </h1>
            <small>Last update: {{ formatDate({}, customer.updated_at) }}</small>

        </div>


        <div class="flex mt-10 flex-wrap">

            <!-- customer -->
            <div class="w-1/2">
                <customer-form
                    @submit="updateCustomer"    
                    :isReady="customerIsReady"
                    :customerClass="customerClass"
                    :model="getCustomerModel"
                    :isEdit="customerBeingEdited !== null">

                    <template v-slot:buttons>
                        <template  v-if="customerBeingEdited">
                            <button type="button" class="btn btn-default" id="cancelEditCustomer" @click="cancelEditCustomer">Cancel</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </template>
                        <template v-else>
                            <button type="button" v-if="isEditable" class="btn btn-default"  id="editCustomer" @click="editCustomer">Edit</button>
                        </template>  
                    </template>

                </customer-form>                    
            </div>

            <!-- upload -->
            <div class="w-1/2">
                <upload 
                    resource-type="customer" 
                    :resource-id="customer.id" 
                    :allowUploads="true"
                    :allowDeletes="isDestroyable"
                    v-if="customerIsReady">
                </upload>
            </div>

            
            <div class="w-full mb-32">
                <invoice-index 
                    v-if="invoicesAreReady" 
                    :shouldHandleOwnLoading="false" 
                    :filteredInvoices="invoices"
                    :customer="customer"
                    :hiddenFields="['full_name', 'description', 'date', 'registered_date']">
                </invoice-index>
            </div>

            <div class="w-full mb-10">
                <payment-index 
                    v-if="paymentsAreReady" 
                    :shouldHandleOwnLoading="false" 
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
    import Customer from '@classes/Customer'
    import CustomerForm from '@components/customer/shared/CustomerForm'
    import InvoiceIndex from '@components/invoice/Index/InvoiceIndex'
    import PaymentIndex from '@components/payment/Index/PaymentIndex'
    import Upload from '@components/shared/Upload/Upload'



    export default {
        props: {
            customerId: {
                required: true,
                type: [String, Number]
            },
        },

        components: {
            'customer-form': CustomerForm,
            'invoice-index': InvoiceIndex,
            'payment-index': PaymentIndex,
            'upload': Upload
        },

        mixins: [ UiCommonMethods ],


        created(){
            this.getCustomer(this.customerId);
            this.getCustomerInvoices(this.customerId);
            this.getCustomerPayments(this.customerId);
        }, 

        beforeRouteUpdate (to, from, next) {
            this.getCustomer(this.customerId);
            this.getCustomerInvoices(this.customerId);
            this.getCustomerPayments(this.customerId);

            next();
        },


        data(){
            return {
                customerClass: Customer,
                customer: {},
                invoices: [],
                payments: [],
                customerIsReady: false,
                invoicesAreReady: false,
                paymentsAreReady: false,
                customerBeingEdited: null,
            }
        },

        computed: {
            getCustomerModel(){
                return this.customerBeingEdited ? this.customerBeingEdited : this.customer;
            },
            isEditable() {
                return this.customer.is_editable;
            },
            isDestroyable() {
                return this.customer.is_destroyable;
            }
        },

        methods: {
            async getCustomer(customerId){
                const { data } = await this.customerClass.show(customerId);
                this.customer = data;
                this.customerIsReady = true;
            },
            async getCustomerInvoices(customerId){
                const { data } = await this.customerClass.invoices(customerId);
                this.invoices = data;
                this.invoicesAreReady = true;
            },
            async getCustomerPayments(customerId){
                const { data } = await this.customerClass.payments(customerId);
                this.payments = data;
                this.paymentsAreReady = true;
            },
            async destroyCustomer(){
                const canDelete = await SweetAlert.confirmDelete('customer');
                if (canDelete === false) return;

                const response = await this.customerClass.destroy(this.customerId);
                SweetAlert.fire('Deleted!', `The customer has been deleted.`, 'success');
                router.go(-1)
            },
            editCustomer(){
                const customerBeingEdited = { ...this.customer};
                this.customerBeingEdited = customerBeingEdited;
            },
            async updateCustomer(){
                const {data: {customer}} = await this.customerClass.update(this.customer.id, this.customerBeingEdited);
                this.customerBeingEdited = null;
                this.customer = {...customer};
                SweetAlert.fire('Done!', `The customer has been updated.`, 'success');
            },
            cancelEditCustomer(event, customerId) {
                this.customerBeingEdited = null;
            },
        },




    }
</script>
