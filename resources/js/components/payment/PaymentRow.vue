<template>
    <tr>
        <td>{{payment.id}}</td>
        <td>{{payment.user_id}}</td>
        <td>{{payment.invoice_id}}</td>
        <td>{{payment.net_amount}}</td>
        <td>{{payment.due_date}}</td>
        <td>{{payment.payed_date}}</td>
        <td>
            <button id="destroyPayment" @click="destroyPayment">Delete</button>
        </td>
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

        methods: {
            async destroyPayment(){
                const response = await this.paymentClass.destroy(this.payment.id);
                this.$emit('paymentWasDeleted', response);
            }
        },


    }
</script>
