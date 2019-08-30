<template>
    <div>
        <div>Payment index</div>

        <div>
            <button @click.prevent="storePayment()">add</button>

            
            <ul>
                
                <li v-for="payment in payments" v-bind:key="payment.id">
                    <router-link :to="{ name: 'payment.show', params: { paymentId: payment.id }}">
                        {{ payment.id }} - {{ payment.number }} - {{ payment.payed_date }}
                    </router-link>
                </li>
            </ul>
            
        </div>

    </div>
</template>

<script>
    import Payment from '../../classes/Payment'
    

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
            },
            storePayment(){

            }
        },
    }
</script>
