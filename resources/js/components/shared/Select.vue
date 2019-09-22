<template>
    <div :class="{'select-small': this.small}" class="relative">
        <select
            :required="required"
            :disabled="disabled"
            v-bind:value="value" 
            v-on:change="$emit('input', $event.target.value)" 
            class="select-default">
            <slot></slot>
        </select>
        <div class="select-icon">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        required: {
            type: Boolean,
            required: false,
        },
        value: {
            required: true,
            type: [Number, String]
        },
        small: {
            type: Boolean,
            required: false,
            default: false,
        },
        disabled: {
            type: Boolean,
            required: false,
            default: false,
        }
    },



}
</script>

<style>

    .select-default {
        @apply block appearance-none w-full bg-white border border-gray-400 rounded shadow leading-tight;
        @apply py-2 px-4 text-gray-700;
    }

    .select-icon {
        @apply pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700;
    }

    .select-default:hover:not(:disabled) {
        @apply border-gray-500;
    }

    .select-default:focus:not(:disabled) {
        @apply outline-none shadow-outline;
    }

    .select-default:hover:disabled {
        cursor:not-allowed;
    }

    .select-default:disabled {
        @apply bg-gray-200 text-gray-500 shadow-none;
    }


    .select-default:disabled+.select-icon {
        @apply text-gray-500;
    }





    .select-small {
        display: inline-block;
    }

    .select-small select {
        @apply px-2 py-1 pr-4 text-xs;
    }



</style>