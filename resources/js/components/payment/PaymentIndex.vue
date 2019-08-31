<template>
    <div>
        <div>Payment index</div>

        <div>

            <p v-if="!paymentsAreReady">Loading</p>

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
                        :payment="payment" 
                        v-on:paymentWasDeleted="handlePaymentWasDeleted($event, payment.id)"
                        v-bind:key="payment.id">
                    </payment-row>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
    import Payment from '../../classes/Payment'
    import PaymentRow from './PaymentRow'
    

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
        },

        components: {
            'payment-row': PaymentRow
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
                // console.log(event)
                this.payments = this.payments.filter(payment => payment.id !== paymentId);
            }
        },
    }
</script>
