<template>
    <div class="card">

        <div class="flex">
            <router-link :to="{ name: 'customer.create'}" class="btn btn-default">
                Add new Customer
            </router-link>
        </div>

        <table class="table table-sortable">
            <thead>
                <tr class="thead-row">
                    <th>
                        <button @click.prevent="sort('id')" :class="getSortedClass('id')">
                        Id
                        </button>
                    </th>
                    <th><button @click.prevent="sort('full_name')">Name</button></th>
                    <th><button @click.prevent="sort('email')">Email</button></th>
                    <th><button @click.prevent="sort('phone')">Phone</button></th>
                    <th><button @click.prevent="sort('vat_code')">VAT</button></th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!customersAreReady">
                    <td colspan="5" rowspan="10" class="h-64">
                        Loading
                    </td>
                </tr>
                <tr v-else v-for="customer in getSortedCustomers" v-bind:key="customer.id">
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
    import _orderBy from 'lodash/orderBy'
    

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
                customersAreReady: false,

                sortColumn: 'id',
                sortDirection: 'asc',
            }
        },

        computed: {
            getSortedCustomers(){
                const property = this.sortColumn;
                const order = this.sortDirection;
                return _orderBy(this.customers, (c) => c[property], order);
            },
            
        },

        methods: {
            async getCustomers(){
                const { data } = await this.customerClass.index();
                this.customers = data;
                this.customersAreReady = true;
            },
            sort(column){
                if (this.sortColumn === column) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortColumn = column;
                    this.sortDirection = 'asc';
                }
            },
            getSortedClass(column){
                if (this.sortColumn === column) {
                    return `sort-${this.sortDirection}`;
                }
            }
        },
    }
</script>

