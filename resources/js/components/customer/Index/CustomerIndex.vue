<template>
    <div class="card">

        <div class="flex">
            <router-link :to="{ name: 'customer.create'}" class="btn btn-default">
                Add new Customer
            </router-link>
        </div>


        <data-table 
        :collection="customers" 
        :fields="fields" 
        :dataIsReady="customersAreReady"></data-table>

    </div>
</template>

<script>
    import Customer from '@classes/Customer'
    import DataTable from '@components/shared/DataTable/DataTable'
    import DataTableFields from './DataTableFields'

    

    export default {

        components: {
            'data-table': DataTable,
        },
        
        mounted(){
            this.getCustomers();
        },

        beforeRouteUpdate (to, from, next) {
            this.getCustomers();
            next();
        },


        data(){
            return {
                customerClass: Customer,
                customers: [],
                customersAreReady: false,

                fields: DataTableFields,
            }
        },



        methods: {
            async getCustomers(){
                const { data } = await this.customerClass.index();
                this.customers = data;
                this.customersAreReady = true;
            }
        },
    }
</script>

