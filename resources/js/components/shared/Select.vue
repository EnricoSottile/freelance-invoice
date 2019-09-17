<template>
    <div class="inline-block relative">
        <select 
            v-bind:value="value" 
            v-on:change="$emit('input', $event.target.value)" 
            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-1 pr-4 text-xs rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <slot></slot>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
    </div>
</template>

<script>
export default {
    
    props: ['value']
}
</script>