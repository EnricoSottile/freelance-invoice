<template>
    <div>
        <div>Customer index</div>

        <div>
            <router-link :to="{ name: 'customer.create'}">
                Add new Customer
            </router-link>

            <p v-if="!customersAreReady">Loading</p>

            <ul>
                <li v-for="customer in customers" v-bind:key="customer.id">
                    <router-link :to="{ name: 'customer.show', params: { customerId: customer.id }}">
                        {{ customer.id }} - {{ customer.full_name }}
                    </router-link>
                </li>
            </ul>
            
        </div>

    </div>
</template>

<script>
    import Customer from '../../classes/Customer'
    

    export default {
        
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
                customersAreReady: false
            }
        },

        methods: {
            async getCustomers(){
                const { data } = await this.customerClass.index();
                this.customers = data;
                this.customersAreReady = true;
            },
        },
    }
</script>
