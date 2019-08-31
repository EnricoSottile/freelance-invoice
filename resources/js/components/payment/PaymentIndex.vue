<template>
    <div>
        <h1>Payment index</h1>

            <p v-if="!paymentsAreReady">Loading</p>

            <template v-else>
                


                <!-- ADD NEW PAYMENT -->
                <add-payment 
                    :invoice="invoice"
                    :paymentClass="paymentClass"
                    v-on:paymentWasSaved="handlePaymentWasSaved">
                </add-payment>



                <!-- EXISTING PAYMENTS -->
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>User id</th>
                            <th>Invoice id</th>
                            <th>net_amount</th>
                            <th>due_date</th>
                            <th>payed_date</th>
                            <th>delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <payment-row 
                            v-for="payment in payments" 
                            :paymentClass="paymentClass"
                            :payment="payment" 
                            v-on:paymentWasDeleted="handlePaymentWasDeleted($event, payment.id)"
                            v-bind:key="payment.id">
                        </payment-row>
                    </tbody>
                </table>

            </template>

    </div>
</template>

<script>
    import Payment from '../../classes/Payment'
    import PaymentRow from './PaymentRow'
    import AddPayment from './AddPayment'
    

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
            }
        },

        components: {
            'payment-row': PaymentRow,
            'add-payment': AddPayment
        },

        mounted(){
            this.getPayments();
        },

        beforeRouteUpdate (to, from, next) {
            this.getPayments();
            next();
        },


        data(){
            return {
                paymentClass: new Payment(),
                payments: [],
                paymentsAreReady: false,
            }
        },

        computed: {
            canAddNewPayment(){
                return this.invoice && this.invoice.id
            }
        },

        methods: {
            async getPayments(){
                if (this.shouldHandleOwnLoading) {
                    const { data } = await this.paymentClass.index();
                    this.payments = data;
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
            }
        },
    }
</script>
