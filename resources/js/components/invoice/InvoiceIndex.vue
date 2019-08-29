<template>
    <div>
        <div>Invoice index</div>

        <div>
            <button @click.prevent="storeCustomer()">add</button>

            
            <ul>
                
                <li v-for="invoice in invoices" v-bind:key="invoice.id">
                    <router-link :to="{ name: 'invoice.show', params: { invoice: invoice.id }}">
                        {{ invoice.id }} - {{ invoice.number }}
                    </router-link>
                </li>
            </ul>
            
        </div>

    </div>
</template>

<script>
    import Invoice from '../../classes/Invoice'
    

    export default {
        
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
                const { data } = await this.invoiceClass.index();
                this.invoices = data;
            },
        },
    }
</script>
