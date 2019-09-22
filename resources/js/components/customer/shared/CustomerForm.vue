<template>
    <form class="pr-6 flex flex-wrap" @submit.prevent="$emit('submit')">

        <template v-if="isReady">

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Full name
                </label>
                <input class="input-default" 
                    required
                    :readonly="!isEdit"
                    v-model="model.full_name" 
                    name="full_name" 
                    placeholder="Full name" 
                    type="text"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Email
                </label>

                <input class="input-default"
                    :readonly="!isEdit" 
                    v-model="model.email" 
                    name="email" 
                    placeholder="Email" 
                    type="email"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Phone
                </label>

                <input class="input-default" 
                    :readonly="!isEdit"
                    v-model="model.phone" 
                    name="phone" 
                    placeholder="Phone" 
                    type="text"/>
            </div>

            <div class="mb-6 w-1/2 px-2">
                <label class="label-default">
                    Vat code
                </label>

                <input class="input-default" 
                    :readonly="!isEdit"
                    v-model="model.vat_code" 
                    name="vat_code" 
                    placeholder="Vat code" 
                    type="number"/>
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
    </form>
</template>

<script>

    export default {

        props: {
            customerClass: {
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
    
    }
</script>