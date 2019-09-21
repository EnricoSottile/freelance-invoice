<template>
    <div>

        <div class="card-title">
            <h1>
                Payment {{ payment.id }} of {{ formatDate({}, payment.created_at) }}

                <button 
                    v-if="isDestroyable"
                    id="destroyPayment"
                    @click="destroyPayment"
                    class="btn btn-xs btn-danger btn-circle text-xl inline-block">
                    <span v-html="getIcon('trash')" class="flex justify-center align-middle"></span>
                </button>

                <label v-if="!isDestroyable" class="inline-block">
                    <span v-html="getIcon('lock')" class="flex justify-center align-middle text-gray-500"></span>
                </label>

                
            </h1>
            <small>Last update: {{ formatDate({}, payment.updated_at) }}</small>

        </div>


        <div class="flex mt-10 flex-wrap">

            <!-- payment -->
            <div class="w-1/2">
                <payment-form
                    :isReady="paymentIsReady"
                    :paymentClass="paymentClass"
                    :model="getPaymentModel"
                    :isEdit="paymentBeingEdited !== null">

                    <template v-slot:buttons>
                        <template  v-if="paymentBeingEdited">
                            <button class="btn btn-default" id="cancelEditPayment" @click="cancelEditPayment">Cancel</button>
                            <button class="btn btn-success" id="updatePayment" @click="updatePayment">Update</button>
                        </template>
                        <template v-else>
                            <button v-if="isEditable" class="btn btn-default"  id="editPayment" @click="editPayment">Edit</button>
                        </template>  
                    </template>

                </payment-form>                    
            </div>

            <!-- upload -->
            <div class="w-1/2">
                <upload 
                    resource-type="payment" 
                    :resource-id="payment.id" 
                    :allowUploads="true"
                    :allowDeletes="isDestroyable"
                    v-if="paymentIsReady">
                </upload>
            </div>
        </div>



    </div>
</template>

<script>
    import _getIcon from '@helpers/getIcon'
    import _formatDate from '@helpers/formatDate'

    import SweetAlert from '@classes/SweetAlert'
    import Payment from '@classes/Payment'
    import PaymentForm from '@components/payment/shared/PaymentForm'
    import Upload from '@components/shared/Upload/Upload'
    
    

    export default {
        props: {
            paymentId: {
                required: true,
                type: [String, Number]
            },
        },

        components: {
            'upload': Upload,
            'payment-form': PaymentForm,
        },


        created(){
            this.getPayment(this.paymentId);
        },

        beforeRouteUpdate (to, from, next) {
            const paymentId = to.params.paymentId;
            this.getPayment(paymentId);
            next();
        },


        data(){
            return {
                paymentClass: Payment,
                payment: {},
                paymentIsReady: false,
                paymentBeingEdited: null,
            }
        },

        computed: {
            getPaymentModel(){
                return this.paymentBeingEdited ? this.paymentBeingEdited : this.payment;
            },
            isEditable() {
                return this.payment.payed_date === null;
            },
            isDestroyable() {
                return this.payment.payed_date === null;
            },
        },

        methods: {
            async getPayment(paymentId){
                const { data } = await this.paymentClass.show(paymentId);
                this.payment = data;
                this.paymentIsReady = true;
            },
            async destroyPayment(){
                const canDelete = await SweetAlert.confirmDelete('payment');
                if (canDelete === false) return;
                    
                const response = await this.paymentClass.destroy(this.paymentId);
                SweetAlert.fire('Deleted!', `The payment has been deleted.`, 'success');

                router.go(-1)
            },
            editPayment(){
                const paymentBeingEdited = { ...this.payment};
                this.paymentBeingEdited = paymentBeingEdited;
            },
            async updatePayment(){
                const {data: {payment}} = await this.paymentClass.update(this.payment.id, this.paymentBeingEdited);
                this.paymentBeingEdited = null;
                this.payment = {...payment};
                SweetAlert.fire('Updated!', `The payment has been updated.`, 'success');
            },
            cancelEditPayment(event, paymentId) {
                this.paymentBeingEdited = null;
            },

            formatDate(options, value) {
                return _formatDate(options, value)
            },
            getIcon(icon) {
                return _getIcon(icon);
            }
        },




    }
</script>

