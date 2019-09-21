<template>
    <div>

        <div class="card-title">
            <h1>
                Create new payment                
            </h1>
        </div>

        <div class="flex mt-10">
            <div class="w-1/2">
                <payment-form
                    :paymentClass="paymentClass"
                    :model="payment"
                    :isEdit="true">

                    <template v-slot:buttons>
                        <button class="btn btn-success" id="saveNewPayment" @click="saveNewPayment">Save</button>
                    </template>

                </payment-form>  
            </div>
        </div>


    </div>
</template>

<script>    
    import SweetAlert from '@classes/SweetAlert'

    import Payment from '@classes/Payment'
    import PaymentForm from '@components/payment/shared/PaymentForm'


    export default {

        props: {
            invoiceId: {
                required: false,
                default: null,
                type: [String, Number]
            },
        },

        components: {
            'payment-form': PaymentForm
        },

        created(){
            this.payment = this.paymentClass.create();
            this.setInvoice(this.invoiceId);
        },

        beforeRouteUpdate (to, from, next) {            
            const invoiceId = to.params.invoiceId;
            this.payment = this.paymentClass.create();
            this.setInvoice(invoiceId);
            next();
        },

        data(){
            return {
                paymentClass: Payment,
                payment: {},
            }
        },



        methods: {
            async saveNewPayment(){
                const {data: {payment}} = await this.paymentClass.store(this.payment);
                SweetAlert.fire('Done!', `The payment has been created.`, 'success');
                router.push({ name: 'payment.show', params: { paymentId: payment.id } })
            },
            setInvoice(invoiceId){
                if (invoiceId === null) return;
                this.payment.invoice_id = invoiceId;
            }
        },
    }
</script>
