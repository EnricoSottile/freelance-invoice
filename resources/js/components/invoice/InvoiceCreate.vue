<template>
    <div>

        <div>Invoice create</div>

        <div v-if="customersAreReady">
            <select v-model="invoice.customer_id">
                <option default selected value="">Choose a customer</option>
                <option 
                    v-bind:key="customer.id" 
                    v-for="customer in customers" 
                    :value="customer.id">
                    {{ customer.full_name }}
                    </option>
            </select>
            {{ invoice.customer_id }}
            <br/>
            <input v-model="invoice.number" name="number" placeholder="Number" type="number"/><br/>
            <input v-model="invoice.net_amount" name="net_amount" placeholder="Net amount" type="number"/><br/>
            <input v-model="invoice.tax" name="tax" placeholder="Tax" type="number"/><br/>
            <input v-model="invoice.description" name="description" placeholder="Description" type="text"/><br/>
            <input v-model="invoice.date" name="date" placeholder="Date" type="date"/><br/>
            <input v-model="invoice.sent_date" name="sent_date" placeholder="Sent date" type="date"/><br/>
            <input v-model="invoice.registered_date" name="registered_date" placeholder="Registered date" type="date"/><br/>
            <button id="saveNewInvoice" @click="saveNewInvoice">Save</button>
        </div>
        <p v-else>
            loading
        </p>

    </div>
</template>

<script>    
    import Invoice from '@classes/Invoice'


    export default {

        props: {
            customerId: {
                required: false,
                default: null,
                type: [String, Number]
            },
        },

        mounted(){
            this.invoice = this.invoiceClass.create();
            this.setCustomer(this.customerId);
            this.getCustomers();
        },

        beforeRouteUpdate (to, from, next) {
            const customerId = to.params.customerId;
            this.invoice = this.invoiceClass.create();
            this.setCustomer(customerId);
            this.getCustomers();
            next();
        },

        data(){
            return {
                invoiceClass: Invoice,
                invoice: {},
                customers: [],
                customersAreReady: false
            }
        },

        methods: {
            async saveNewInvoice(){
                const {data: {invoice}} = await this.invoiceClass.store(this.invoice);
                alert('invoice was added');
                router.push({ name: 'invoice.show', params: { invoiceId: invoice.id } })
            },
            async getCustomers(){
                const { data } = await this.invoiceClass.customers();
                this.customers = data;
                this.customersAreReady = true;
            },
            setCustomer(customerId){
                if (customerId === null) return;
                this.invoice.customer_id = customerId;
            }
        },
    }
</script>
