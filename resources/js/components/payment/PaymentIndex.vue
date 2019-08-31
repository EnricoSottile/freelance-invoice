<template>
    <div>
        <h1>Payment index</h1>

            <p v-if="!paymentsAreReady">Loading</p>

            <template v-else>
                


                <!-- ADD NEW PAYMENT -->
                <button id="addPayment" 
                    v-if="canAddNewPayment && !newPayment" 
                    @click.prevent="addNewPayment()">
                    add new payment
                </button>
                
                <template v-if="newPayment">
                    <input v-model="newPayment.net_amount" name="net_amount" placeholder="Net amount" type="number"/>
                    <input v-model="newPayment.due_date" name="due_date" placeholder="Due date" type="date"/>
                    <button id="saveNewPayment" @click="saveNewPayment">Save</button>
                    <button id="cancelNewPayment" @click="cancelNewPayment">Cancel</button>
                </template>



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
                newPayment: null
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
            addNewPayment(){
                const newPayment = this.paymentClass.create(this.invoice.id);
                this.newPayment = newPayment;
            },
            async saveNewPayment(){
                const payment = await this.paymentClass.store(this.newPayment);
                this.payments.push(payment);
                this.newPayment = null;
            },
            cancelNewPayment(event, paymentId) {
                this.newPayment = null;
            }
        },
    }
</script>
