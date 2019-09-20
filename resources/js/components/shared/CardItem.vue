<template>
    <div class="max-w-sm rounded overflow-hidden shadow-xl bg-white">
        <div class="h-32 overflow-hidden">
            <slot name="image"></slot>
        </div>
        <div class="px-4 py-2">
            <slot name="body"></slot>
        </div>
        <div class="px-4 py-2">
            <slot name="footer"></slot>
            <!-- <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#photography</span>
            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#travel</span>
            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#winter</span> -->
        </div>
    </div>
</template>

<script>
export default {

}
</script>