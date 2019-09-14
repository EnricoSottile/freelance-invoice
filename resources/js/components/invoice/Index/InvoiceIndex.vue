<template>
    <div class="card">

        <div class="flex">
                <!-- ADD NEW INVOICE -->
                <template v-if="customer !== null">
                    <router-link class="btn btn-default" :to="{ name: 'customer.invoice.create', params: {customer}}">
                        Add new Invoice
                    </router-link>
                </template>
                <template v-else>
                    <router-link class="btn btn-default" :to="{ name: 'invoice.create'}">
                        Add new Invoice
                    </router-link>
                </template>

        </div>


        <data-table 
        :collection="invoices" 
        :fields="fields" 
        :dataIsReady="invoicesAreReady"></data-table>

    </div>
</template>


<script>
    import Invoice from '@classes/Invoice'
    import DataTable from '@components/shared/DataTable/DataTable'
    import DataTableFields from './DataTableFields'

    export default {

        components: {
            'data-table': DataTable,
        },

        props: {
            shouldHandleOwnLoading: {
                type: Boolean,
                required: true,
            },
            filteredInvoices: {
                type: Array,
                required: false,
            },
            customer: {
                type: Object,
                required: false,
                default: null
            }
        },

        mounted(){
            this.getInvoices();
        },

        beforeRouteUpdate (to, from, next) {
            this.getInvoices();
            next();
        },


        data(){
            return {
                invoiceClass: Invoice,
                invoices: [],
                invoicesAreReady: false,

                fields: DataTableFields,
            }
        },

        computed: {
            getCreateParams(){
                return this.customer !== null ? {customer: this.customer} : {};
            }
        },

        methods: {
            async getInvoices(){
                if (this.shouldHandleOwnLoading) {
                    const { data } = await this.invoiceClass.index();
                    this.invoices = data;
                } else {
                    this.invoices = this.filteredInvoices;
                }

                this.invoicesAreReady = true;
            }
        },
    }
</script>
