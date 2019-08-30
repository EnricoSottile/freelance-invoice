<template>
    <div>
        <div>Invoice index</div>

        <div>
            <button @click.prevent="storeInvoice()">add</button>

            
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
            },
            storeInvoice(){

            }
        },
    }
</script>
