<template>
    <div>
        <div>Payment show</div>

        <div >
            <pre>{{ payment }}</pre>
        </div>  


        <upload 
            resource-type="payment" 
            :resource-id="payment.id" 
            :allowUploads="isEditable"
            :allowDeletes="isDestroyable"
            v-if="paymentIsReady">
        </upload>


    </div>
</template>

<script>
    import Payment from '@classes/Payment'
    import Upload from '@components/upload/Upload'


    export default {
        props: {
            paymentId: {
                required: true,
                type: [String, Number]
            },
        },

        components: {
            'upload': Upload
        },


        mounted(){
            this.getPayment(this.paymentId);
        },

        beforeRouteUpdate (to, from, next) {
            const paymentId = to.params.paymentId;
            this.getPayment(invoiceId);
            next();
        },


        data(){
            return {
                paymentClass: Payment,
                payment: {},
                paymentIsReady: false,
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
            async getPayment(paymentId){
                const { data } = await this.paymentClass.show(paymentId);
                this.payment = data;
                this.paymentIsReady = true;
            },
        },




    }
</script>

