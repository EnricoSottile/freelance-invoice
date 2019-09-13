<template>
    <div class="card">

        <div class="flex">
            <router-link :to="{ name: 'customer.create'}" class="btn btn-default">
                Add new Customer
            </router-link>
        </div>


        <p v-if="!customersAreReady">Loading</p>

        <table v-else class="table">
            <thead>
                <tr class="thead-row">
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>VAT</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="customer in customers" v-bind:key="customer.id">
                    <td>
                        {{ customer.id }}
                    </td>
                    <td>
                        <router-link :to="{ name: 'customer.show', params: { customerId: customer.id }}">
                            {{ customer.full_name }}
                        </router-link>
                    </td>
                    <td>
                        {{ customer.email }}
                    </td>
                    <td>
                        {{ customer.phone }}
                    </td>
                    <td>
                        {{ customer.vat_code }}
                    </td>
                </tr>
            </tbody>
        </table>


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

