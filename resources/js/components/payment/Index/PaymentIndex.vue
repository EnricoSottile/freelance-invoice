<template>
    <div>
        

        <div class="flex mt-10 justify-between">
                <h1 class="font-light text-2xl">Payments</h1>


                <!-- ADD NEW PAYMENT -->
                <template v-if="invoice !== null">
                    <router-link class="btn btn-default" :to="{ name: 'invoice.payment.create', params: {invoice}}">
                        Add new Payment
                    </router-link>
                </template>
                <template v-else>
                    <router-link class="btn btn-default" :to="{ name: 'payment.create'}">
                        Add new Payment
                    </router-link>
                </template>
                

        </div>


        <data-table 
            :collection="payments" 
            :fields="fields" 
            :dataIsReady="paymentsAreReady">
        </data-table>




    </div>


</template>

<script>
    import Payment from '@classes/Payment'

    import DataTable from '@components/shared/DataTable/DataTable'
    import DataTableFields from './DataTableFields'
    

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
                default: null,
            },
            hiddenFields: {
                type: Array,
                required: false,

                // Props with type Object/Array must use a factory function 
                // to return the default value.
                default: () => []
            }
        },

        components: {
            'data-table': DataTable
        },

        created(){
            this.getPayments();
            this.setDataTableFields();
        },

        beforeRouteUpdate (to, from, next) {
            this.getPayments();
            this.setDataTableFields();
            next();
        },


        data(){
            return {
                paymentClass: Payment,
                payments: [],
                paymentsAreReady: false,

                fields: null
            }
        },


        methods: {
            // programmatically hide fields from DataTable
            setDataTableFields(){
                this.fields = DataTableFields.filter(field => {
                    return ! this.hiddenFields.includes(field.name);
                });
            },

            async getPayments(){
                if (this.shouldHandleOwnLoading) {
                    const { data } = await this.paymentClass.index();
                    this.payments =  data.map(p => ({...p, invoice_number: p.invoice.number}));
                } else {
                    this.payments = this.filteredPayments;
                }

                this.paymentsAreReady = true;
            },
        },
    }
</script>
