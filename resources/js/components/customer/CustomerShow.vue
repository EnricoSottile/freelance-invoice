<template>
    <div>
        <div>Customer show</div>

        <div>
            <pre>{{ customer }}</pre>
        </div>
    </div>
</template>

<script>
    export default {

        mounted(){
            this.getCustomer(this.$route);
        },

        beforeRouteUpdate (to, from, next) {
            this.getCustomer(to);
            next();
        },


        data(){
            return {
                customer: {},
            }
        },

        methods: {
            async getCustomer(route){
                const { data } = await axios.get(route.path);
                this.customer = data;
            },
        },




    }
</script>
