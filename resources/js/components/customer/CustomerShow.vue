<template>
    <div>
        <div>Customer show</div>

        <div>
            <pre>{{ customer }}</pre>
        </div>
    </div>
</template>

<script>
    import Customer from '../../classes/Customer'

    export default {


        mounted(){
            this.getCustomer(this.$route.params.customer);
        },

        beforeRouteUpdate (to, from, next) {
            this.getCustomer(to.params.customer);
            next();
        },


        data(){
            return {
                customerClass: new Customer(),
                customer: {},
            }
        },

        methods: {
            async getCustomer(customerId){
                const { data } = await this.customerClass.show(customerId);
                this.customer = data;
            },
        },




    }
</script>
