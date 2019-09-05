<template>
    <div>

        <div>Customer create</div>

        <div>
            <input v-model="customer.full_name" name="full_name" placeholder="Full name" type="text"/><br/>
            <input v-model="customer.email" name="email" placeholder="Email" type="email"/><br/>
            <input v-model="customer.phone" name="phone" placeholder="Phone" type="text"/><br/>
            <input v-model="customer.vat_code" name="vat_code" placeholder="Vat code" type="number"/><br/>
            <button id="saveNewCustomer" @click="saveNewCustomer">Save</button>
        </div>

    </div>
</template>

<script>    
    import Customer from '../../classes/Customer'


    export default {


        mounted(){
            this.customer = this.customerClass.create();
        },

        beforeRouteUpdate (to, from, next) {
            this.customer = this.customerClass.create();
            next();
        },

        data(){
            return {
                customerClass: Customer,
                customer: {},
            }
        },



        methods: {
            async saveNewCustomer(){
                const {data: {customer}} = await this.customerClass.store(this.customer);
                alert('customer was added');
                router.push({ name: 'customer.show', params: { customerId: customer.id } })
            },
        },
    }
</script>
