<template>
    <div>
        <div>Invoice index</div>

        <div>
            <p v-if="!invoicesAreReady">Loading</p>

            <div v-else>
                <!-- ADD NEW INVOICE -->
                <template v-if="customer !== null">
                    <router-link :to="{ name: 'customer.invoice.create', params: {customer}}">
                        Add new Invoice
                    </router-link>
                </template>
                <template v-else>
                    <router-link :to="{ name: 'invoice.create'}">
                        Add new Invoice
                    </router-link>
                </template>


                <ul>
                    
                    <li v-for="invoice in invoices" v-bind:key="invoice.id">
                        <router-link :to="{ name: 'invoice.show', params: { invoiceId: invoice.id }}">
                            {{ invoice.id }} - {{ invoice.number }} - {{ invoice.registered_date }}
                        </router-link>
                    </li>
                </ul>

            </div>
            

            
        </div>

    </div>
</template>

<script>
    import Invoice from '@classes/Invoice'
    

    export default {

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
                invoicesAreReady: false
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
