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
    import _append from '@helpers/appendFromNestedProp'

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
            },
            hiddenFields: {
                type: Array,
                required: false,

                // Props with type Object/Array must use a factory function 
                // to return the default value.
                default: () => []
            }
        },

        created(){
            this.getInvoices();
            this.setDataTableFields();
        },

        beforeRouteUpdate (to, from, next) {
            this.getInvoices();
            this.setDataTableFields();
            next();            
        },


        data(){
            return {
                invoiceClass: Invoice,
                invoices: [],
                invoicesAreReady: false,

                fields: null
            }
        },

        computed: {
            getCreateParams(){
                return this.customer !== null ? {customer: this.customer} : {};
            },
        },

        methods: {
            async getInvoices(){
                let invoices;
                if (this.shouldHandleOwnLoading) {
                    const { data } = await this.invoiceClass.index();
                    this.invoices = _append(data, {key: 'full_name', selector: 'customer.full_name'});;
                } else {
                    this.invoices = this.filteredInvoices;
                }

                this.invoicesAreReady = true;
            },

            // programmatically hide fields from DataTable
            setDataTableFields(){
                this.fields = DataTableFields.filter(field => {
                    return ! this.hiddenFields.includes(field.name);
                });
            }

        },
    }
</script>
