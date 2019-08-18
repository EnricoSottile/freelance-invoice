<template>
    <div>
        <div>Customer index</div>

        <div>
            
            <ul>
                <li v-for="customer in customers" v-bind:key="customer.id">
                    <router-link :to="{ name: 'customer.show', params: { customer: customer.id }}">
                        {{ customer.id }} - {{ customer.full_name }}
                    </router-link>
                </li>
            </ul>
            
        </div>

    </div>
</template>

<script>
    export default {
        
        mounted(){
            this.getCustomers(this.$route);
        },

        beforeRouteUpdate (to, from, next) {
            this.getCustomers(to);
            next();
        },


        data(){
            return {
                customers: [],
            }
        },

        methods: {
            async getCustomers(route){
                const { data } = await axios.get(route.path);
                this.customers = data;
            },
        },
    }
</script>
