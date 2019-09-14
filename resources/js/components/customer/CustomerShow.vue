<template>
    <div>
        <div>Customer show</div>

        <div v-if="customerBeingEdited">
            <input v-model="customerBeingEdited.full_name" name="full_name" placeholder="Full name" type="text"/><br/>
            <input v-model="customerBeingEdited.email" name="email" placeholder="Email" type="email"/><br/>
            <input v-model="customerBeingEdited.phone" name="phone" placeholder="Phone" type="text"/><br/>
            <input v-model="customerBeingEdited.vat_code" name="vat_code" placeholder="Vat code" type="number"/><br/>
            <button id="updateCustomer" @click="updateCustomer">Update</button>
            <button id="cancelEditCustomer" @click="cancelEditCustomer">Cancel</button>
            <br/><br/><br/>
        </div>
        <div v-else>
            <pre>{{ customer }}</pre>

            <button id="editCustomer" @click="editCustomer">Edit</button>
            <button v-if="isDestroyable" id="destroyCustomer" @click="destroyCustomer">Delete</button>
            <br/><br/><br/>
        </div>

        <div v-if="customerIsReady" style="display:flex">

            <div>
                <upload 
                    resource-type="customer" 
                    :resource-id="customer.id" 
                    :allowUploads="true"
                    :allowDeletes="isDestroyable">
                </upload>
            </div>

            <div>
                <invoice-index 
                    v-if="invoicesAreReady" 
                    :shouldHandleOwnLoading="false" 
                    :filteredInvoices="invoices"
                    :customer="customer">
                </invoice-index>
            </div>

            <div v-if="paymentsAreReady">
                <payment-index 
                    v-if="paymentsAreReady" 
                    :shouldHandleOwnLoading="false" 
                    :filteredPayments="payments">
                </payment-index>
            </div>

        </div>



        
    </div>
</template>

<script>
    import Customer from '@classes/Customer'
    import InvoiceIndex from '@components/invoice/InvoiceIndex'
    import PaymentIndex from '@components/payment/PaymentIndex'
    import Upload from '@components/upload/Upload'



    export default {
        props: {
            customerId: {
                required: true,
                type: [String, Number]
            },
        },

        components: {
            'invoice-index': InvoiceIndex,
            'payment-index': PaymentIndex,
            'upload': Upload
        },


        mounted(){
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
            hasPayedPayments(){
                return this.payments 
                && this.payments.filter(p => p.payed_date).length;
            },
            hasRegisteredInvoices(){
                return this.invoices 
                && this.invoices.filter(i => i.registered_date).length;
            },
            isDestroyable() {
                return this.hasPayedPayments === 0 
                && this.hasRegisteredInvoices === 0
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
                const response = await this.customerClass.destroy(this.customerId);
                window.alert("customer was deleted");
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
                alert('customer was updated');
            },
            cancelEditCustomer(event, customerId) {
                this.customerBeingEdited = null;
            }
        },




    }
</script>
