<template>
    <tr>
        <td>{{payment.id}}</td>
        <td>{{payment.user_id}}</td>
        <td>{{payment.invoice_id}}</td>

        <template v-if="!paymentBeingEdited">

            <td>{{payment.net_amount}}</td>
            <td>{{payment.due_date}}</td>
            <td>{{payment.payed_date}}</td>
            <td>
                <button v-if="isEditable" :id="`editPayment_${payment.id}`" @click="editPayment">Edit</button>
                <button v-if="isDestroyable" :id="`destroyPayment_${payment.id}`" @click="destroyPayment">Delete</button>
                <router-link :to="{ name: 'payment.show', params: {paymentId: payment.id}}">
                    Detail
                </router-link>
            </td>

        </template>
        <template v-else>

            <td>
                <input v-model="paymentBeingEdited.net_amount" name="net_amount" placeholder="Net amount" type="number"/>
            </td>
            <td>
                <input v-model="paymentBeingEdited.due_date" name="due_date" placeholder="Due date" type="date"/>
            </td>
            <td>
                <input v-model="paymentBeingEdited.payed_date" name="payed_date" placeholder="Payed date" type="date"/>
            </td>
            <td>
                <button :id="`updatePayment_${payment.id}`" @click="updatePayment">Update</button>
                <button :id="`cancelEditPayment_${payment.id}`" @click="cancelEditPayment">Cancel</button>
            </td>

        </template>


    </tr>

</template>

<script>

    export default {
        props: {
            payment: {
                required: true,
                type: Object
            },
            paymentClass: {
                required: true,
                type: Object
            }
        },

        data(){
            return {
                paymentBeingEdited: null,
            }
        },

        computed: {
            isEditable() {
                return this.payment.payed_date === null;
            },
            isDestroyable() {
                return this.payment.payed_date === null;
            }
        },

        methods: {
            async destroyPayment(){
                const response = await this.paymentClass.destroy(this.payment.id);
                this.$emit('paymentWasDeleted', response);
            },
            editPayment(){
                const paymentBeingEdited = { ...this.payment};
                this.paymentBeingEdited = paymentBeingEdited;
            },
            async updatePayment(){
                const payment = await this.paymentClass.update(this.payment.id, this.paymentBeingEdited);
                this.$emit('paymentWasUpdated', payment);
                this.paymentBeingEdited = null;
                alert('payment was updated');
            },
            cancelEditPayment(event, paymentId) {
                this.paymentBeingEdited = null;
            }
        },


    }
</script>
