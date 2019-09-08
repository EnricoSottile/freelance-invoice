<template>
    <div>

        <!-- ADD NEW PAYMENT -->
        <button id="addPayment" 
            v-if="!newPayment" 
            @click.prevent="addNewPayment()">
            add new payment
        </button>
        
        <template v-if="newPayment">
            <input v-model="newPayment.net_amount" name="net_amount" placeholder="Net amount" type="number"/>
            <input v-model="newPayment.due_date" name="due_date" placeholder="Due date" type="date"/>
            <input v-model="newPayment.payed_date" name="payed_date" placeholder="Payed date" type="date"/>
            <button id="saveNewPayment" @click="saveNewPayment">Save</button>
            <button id="cancelNewPayment" @click="cancelNewPayment">Cancel</button>
        </template>


    </div>
</template>

<script>    

    export default {

        props: {
            paymentClass: {
                required: true,
                type: Function
            },
            invoice: {
                type: Object,
                required: true,
            }
        },


        data(){
            return {
                newPayment: null
            }
        },



        methods: {
            addNewPayment(){
                const newPayment = this.paymentClass.create(this.invoice.id);
                this.newPayment = newPayment;
            },
            async saveNewPayment(){
                const payment = await this.paymentClass.store(this.newPayment);
                this.$emit('paymentWasSaved', payment);
                this.newPayment = null;
                alert('payment was added');
            },
            cancelNewPayment(event, paymentId) {
                this.newPayment = null;
            }
        },
    }
</script>
