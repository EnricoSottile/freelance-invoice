<template>
    <div :class="getClass" class="modal absolute w-full h-full top-0 left-0 flex items-center justify-center">
        <div @click="$emit('close');" class="modal-overlay absolute w-full h-full bg-black opacity-25 top-0 left-0 cursor-pointer"></div>
        <div style="height: 75%" class="modal-content absolute w-3/4 overflow-auto bg-white rounded shadow-lg">
            <slot></slot>
        </div>
    </div>

</template>

<script>
export default {
    
    props: {
        show: {
            required: true,
            type: Boolean,
            default: false,
        }
    },


    computed: {
        getClass(){
            if (this.show === true) return;
            return 'opacity-0 pointer-events-none';
        }
    },



}
</script>