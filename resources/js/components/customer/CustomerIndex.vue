<template>
    <div class="card">

        <div class="flex">
            <router-link :to="{ name: 'customer.create'}" class="btn btn-default">
                Add new Customer
            </router-link>
        </div>


        <data-table :collection="customers" :fields="fields" :dataIsReady="customersAreReady"></data-table>

    </div>
</template>

<script>
    import Customer from '../../classes/Customer'
    import DataTable from '../shared/DataTable'

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

                fields: [
                    {name: 'id', label: 'Id'},
                    {
                        name: 'full_name', 
                        label: 'Name',
                        options: {
                            type: 'link',
                            view: 'customer.show',
                            params: {name: 'customerId', property: 'id'}
                        }
                    },
                    {name: 'email', label: 'Email'},
                    {name: 'phone', label: 'Phone'},
                    {name: 'vat_code', label: 'Vat'},
                    {
                        name: 'created_at', 
                        label: 'Created',
                        options: {
                            type: 'date'
                        }
                    },
                ],
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

