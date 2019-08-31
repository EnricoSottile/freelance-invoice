<template>
    <div>
        <div>Invoice index</div>

        <div>
            <p v-if="!invoicesAreReady">Loading</p>
            
            <ul>
                
                <li v-for="invoice in invoices" v-bind:key="invoice.id">
                    <router-link :to="{ name: 'invoice.show', params: { invoiceId: invoice.id }}">
                        {{ invoice.id }} - {{ invoice.number }} - {{ invoice.registered_date }}
                    </router-link>
                </li>
            </ul>
            
        </div>

    </div>
</template>

<script>
    import Invoice from '../../classes/Invoice'
    

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
                invoiceClass: new Invoice(),
                invoices: [],
                invoicesAreReady: false
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
