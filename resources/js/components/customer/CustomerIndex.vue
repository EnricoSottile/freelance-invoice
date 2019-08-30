<template>
    <div>
        <div>Customer index</div>

        <div>
            <button @click.prevent="storeCustomer()">add</button>

            
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
                customerClass: new Customer(),
                customers: [],
            }
        },

        methods: {
            async getCustomers(){
                const { data } = await this.customerClass.index();
                this.customers = data;
            },
            storeCustomer(){
                
            }
        },
    }
</script>
