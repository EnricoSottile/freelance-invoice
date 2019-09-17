<template>
    <div class="card">
        

        <div class="flex mt-10 justify-between">
                <h1 class="font-light text-2xl text-gray-500">Payments</h1>
                
                <add-payment
                    v-if="invoice"
                    :invoice="invoice"
                    :paymentClass="paymentClass"
                    v-on:paymentWasSaved="handlePaymentWasSaved">
                </add-payment>
        </div>


        <data-table 
        :collection="payments" 
        :fields="fields" 
        :dataIsReady="paymentsAreReady">
        </data-table>




    </div>


</template>

<script>
    import Payment from '@classes/Payment'
    import PaymentRow from '../PaymentRow'
    import AddPayment from '../AddPayment'

    import DataTable from '@components/shared/DataTable/DataTable'
    import DataTableFields from './DataTableFields'
    

    export default {

        props: {
            shouldHandleOwnLoading: {
                type: Boolean,
                required: true,
            },
            filteredPayments: {
                type: Array,
                required: false,
            },
            invoice: {
                type: Object,
                required: false,
            },
            hiddenFields: {
                type: Array,
                required: false,

                // Props with type Object/Array must use a factory function 
                // to return the default value.
                default: () => []
            }
        },

        components: {
            'payment-row': PaymentRow,
            'add-payment': AddPayment,
            'data-table': DataTable
        },

        created(){
            this.getPayments();
            this.setDataTableFields();
        },

        beforeRouteUpdate (to, from, next) {
            this.getPayments();
            this.setDataTableFields();
            next();
        },


        data(){
            return {
                paymentClass: Payment,
                payments: [],
                paymentsAreReady: false,

                fields: null
            }
        },

        computed: {
            canAddNewPayment(){
                return this.invoice && this.invoice.id
            }
        },

        methods: {
            // programmatically hide fields from DataTable
            setDataTableFields(){
                this.fields = DataTableFields.filter(field => {
                    return ! this.hiddenFields.includes(field.name);
                });
            },

            async getPayments(){
                if (this.shouldHandleOwnLoading) {
                    const { data } = await this.paymentClass.index();
                    this.payments =  data.map(p => ({...p, invoice_number: p.invoice.number}));
                } else {
                    this.payments = this.filteredPayments;
                }

                this.paymentsAreReady = true;
            },
            handlePaymentWasDeleted(event, paymentId) {
                alert("payment was deleted");
                this.payments = this.payments.filter(payment => payment.id !== paymentId);
            },
            handlePaymentWasSaved(event) {
                this.payments.push(event.data.payment);
            },
            handlePaymentWasUpdated(event) {
                const payment = event.data.payment;
                const index = this.payments.findIndex(p => p.id === payment.id);
                Vue.set(this.payments, index, payment);
            }
        },
    }
</script>
