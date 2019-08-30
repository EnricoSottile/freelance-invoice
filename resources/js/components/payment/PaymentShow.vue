<template>
    <div>
        <div>Payment show</div>

        <div>
            <pre>{{ payment }}</pre>


            <button id="destroyPayment" @click="destroyPayment">Delete</button>
            <br/><br/><br/>
        </div>
    </div>
</template>

<script>
    import Payment from '../../classes/Payment'

    export default {
        props: {
            paymentId: {
                required: true,
                validator(value) {
                    const type = typeof(value);
                    return type === 'string' || type === 'number';
                }
            },
        },


        mounted(){
            this.getPayment(this.paymentId);
        },

        beforeRouteUpdate (to, from, next) {
            this.getPayment(this.paymentId);
            next();
        },


        data(){
            return {
                paymentClass: new Payment(),
                payment: {},
                paymentIsReady: false
            }
        },

        methods: {
            async getPayment(paymentId){
                const { data } = await this.paymentClass.show(paymentId);
                this.payment = data;
                this.paymentIsReady = true;
            },
            async destroyPayment(){
                const response = await this.paymentClass.destroy(this.paymentId);
                alert("payment was deleted");
                router.go(-1)
            }
        },




    }
</script>
