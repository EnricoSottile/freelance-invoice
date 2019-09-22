<template>
    <form class="pr-6 flex flex-wrap" @submit.prevent="$emit('submit')">

        <template v-if="customersAreReady && isReady">
            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Customer
                </label>

                <custom-select 
                    :required="true"
                    :disabled="!isEdit"
                    v-model="model.customer_id">
                        <option default selected value="">Choose a customer</option>
                        <option 
                            v-bind:key="customer.id" 
                            v-for="customer in customers" 
                            :value="customer.id">
                            {{ customer.full_name }}
                        </option>
                </custom-select>
            </div>

            <div class="mb-6 w-1/2 px-2"></div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Number
                </label>
                <input class="input-default" 
                    required
                    :readonly="!isEdit"
                    v-model="model.number" 
                    name="number" 
                    placeholder="Number" 
                    type="number"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Net amount
                </label>
                <money
                    required
                    class="input-default"
                    :readonly="!isEdit"
                    v-model="model.net_amount" 
                    name="net_amount" 
                    placeholder="Net amount" 
                ></money>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Tax
                </label>
                <money
                    required
                    class="input-default"
                    :readonly="!isEdit"
                    v-model="model.tax" 
                    name="tax" 
                    placeholder="Tax" 
                    v-bind="percent"
                ></money>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Date
                </label>

                <input class="input-default"
                    :readonly="!isEdit" 
                    v-model="model.date" 
                    name="date" 
                    placeholder="date" 
                    type="date"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Sent date
                </label>

                <input class="input-default" 
                    :readonly="!isEdit"
                    v-model="model.sent_date" 
                    name="sent_date" 
                    placeholder="Sent date" 
                    type="date"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Registered date
                </label>

                <input class="input-default" 
                    :readonly="!isEdit"
                    v-model="model.registered_date" 
                    name="registered_date" 
                    placeholder="Registered date" 
                    type="date"/>
            </div>

            <div class="mb-6 w-full px-2">
                <label class="label-default">
                    Description
                </label>

                <input class="input-default" 
                    :readonly="!isEdit"
                    v-model="model.description" 
                    name="description" 
                    placeholder="Description" 
                    type="text"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <slot name="buttons"></slot>                      
            </div>
        </template>

        <template v-else>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default bg-gray-200 w-16">&nbsp;</label>
                <input class="input-default" readonly="true"/>
            </div>

            <div class="mb-6 w-1/2 px-2"></div>

            <div class="mb-6 w-1/2 px-2" v-for="item in 6" v-bind:key="item">
                <label class="label-default bg-gray-200 w-16">&nbsp;</label>
                <input class="input-default" readonly="true"/>
            </div>

            <div class="mb-6 w-full px-2">
                <label class="label-default bg-gray-200 w-16">&nbsp;</label>
                <input class="input-default" readonly="true"/>
            </div>

        </template>
    </form>
</template>

<script>
    import Select from '@components/shared/Select'
    import { Money } from 'v-money'

    export default {

        props: {
            invoiceClass: {
                type: [Function, Object],
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
            'money' : Money,
            'custom-select': Select,
        },


        created(){
            this.getCustomers();
        },

        data(){
            return {
                customers: [],
                customersAreReady: false,
                percent: {
                    suffix: ' %',
                    precision: 2,
                }
            }
        },


        methods: {
            async getCustomers(){
                const { data } = await this.invoiceClass.customers();
                this.customers = data;
                this.customersAreReady = true;
            },
        }

    
    }
</script>