<template>
    <div>
        
        <div class="card-title">
            <h1>
                Create new customer                
            </h1>
        </div>

        <div class="flex mt-10">
            <div class="w-1/2">
                <customer-form
                    @submit="saveNewCustomer"
                    :customerClass="customerClass"
                    :model="customer"
                    :isEdit="true">

                    <template v-slot:buttons>
                        <button type="submit" class="btn btn-success">Save</button>
                    </template>

                </customer-form>  
            </div>
        </div>

    </div>
</template>

<script>    
    import SweetAlert from '@classes/SweetAlert'

    import Customer from '@classes/Customer'
    import CustomerForm from '@components/customer/shared/CustomerForm'


    export default {

        components: {
            'customer-form': CustomerForm
        },

        created(){
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
                SweetAlert.fire('Done!', `The customer has been created.`, 'success');
                router.push({ name: 'customer.show', params: { customerId: customer.id } })
            },
        },
    }
</script>
