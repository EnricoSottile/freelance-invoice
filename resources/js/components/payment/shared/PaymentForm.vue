<template>
    <div class="pr-6 flex flex-wrap">

        <template v-if="invoicesAreReady && isReady">
            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Invoice
                </label>

                <custom-select 
                    :disabled="!isEdit"
                    v-model="model.invoice_id">
                        <option default selected value="">Choose an invoice</option>
                        <option 
                            v-bind:key="invoice.id" 
                            v-for="invoice in invoices" 
                            :value="invoice.id">
                            {{ invoice.number }}
                        </option>
                </custom-select>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Net amount
                </label>
                <input class="input-default" 
                    :readonly="!isEdit"
                    v-model="model.net_amount" 
                    name="net_amount" 
                    placeholder="Net amount" 
                    type="number"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Due date
                </label>

                <input class="input-default"
                    :readonly="!isEdit" 
                    v-model="model.due_date" 
                    name="due_date" 
                    placeholder="Due date" 
                    type="date"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Payed date
                </label>

                <input class="input-default" 
                    :readonly="!isEdit"
                    v-model="model.payed_date" 
                    name="payed_date" 
                    placeholder="Payed date" 
                    type="date"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <slot name="buttons"></slot>                      
            </div>
        </template>

        <template v-else>
            <div class="mb-6 w-1/2 px-2" v-for="item in 4" v-bind:key="item">
                <label class="label-default bg-gray-200 w-16">&nbsp;</label>
                <input class="input-default" readonly="true"/>
            </div>
        </template>
    </div>
</template>

<script>
    import Select from '@components/shared/Select'

    export default {

        props: {
            paymentClass: {
                type: Function,
                required: true,
            },
            isReady: {
                type: Boolean,
                required: false,
                default: true,
            },
            // the payment model
            // it can be edited whitouth "emit"
            // because on the parent it's cloned from the main data object
            // and returned as computed
            model: {
                type: Object,
                required: true
            },
            isEdit: {
                type: Boolean,
                required: true,
            }
        },


        components: {
            'custom-select': Select,
        },

        created(){
            this.getInvoices();
        },

        data(){
            return {
                invoices: [],
                invoicesAreReady: false,
            }
        },


        methods: {
            async getInvoices(){
                const { data } = await this.paymentClass.invoices();
                this.invoices = data;
                this.invoicesAreReady = true;
            },
        }

    
    }
</script>