<template>
    <div class="mx-1 flex items-center justify-between">

        <span>
            <small class="text-gray-500">items per page</small>
            <custom-select 
                v-bind:value="itemsPerPage"
                v-on:input="handleInput($event)">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
            </custom-select>
        </span>
        
        <small class="text-gray-500">
            {{ getPaginationSegment.first }}
            -
            {{ getPaginationSegment.last }}
            of 
            {{ getPaginationSegment.total }}
        </small>

        <span class="flex">
            <button class="btn btn-xs btn-default btn-circle text-xl" 
                :disabled="!hasPrevPage" 
                @click.prevent="setPage('prev')">&lsaquo;</button>
            <button class="btn btn-xs btn-default btn-circle text-xl" 
                :disabled="!hasNextPage" 
                @click.prevent="setPage('next')">&rsaquo;</button>
        </span>

    </div>
</template>

<script>
import Select from '@components/shared/Select'

export default {
    
    props: {
        totalItems: {
            type: [Number, String],
            required: true,
        },
        itemsPerPage: {
            type: [Number, String],
            required: true,
        },
        currentPage: {
            type: [Number, String],
            required: true,
        },
        pages: {
            type: [Number, String],
            required: true,
        }
    },

    

    components: {
        'custom-select': Select,
    },

    computed: {
        getPaginationSegment(){
            const first = (this.itemsPerPage * (this.currentPage-1)) +1;
            const last = this.currentPage * this.itemsPerPage;
            const total = this.totalItems;
            
            return {
                first,
                last: last > total ? total : last,
                total
            }
        },
        hasPrevPage(){
            return this.currentPage > 1;
        },
        hasNextPage(){
            return this.currentPage < this.pages;
        }
    },

    methods: {
        handleInput(event){
            this.$emit('input', event); // this enables v-model on parent
            this.setPage('first');
        },
        setPage(direction){
            
            if (direction === 'next' && this.hasNextPage) {
                this.$emit('setPage', 'next')
            }

            if (direction === 'prev' && this.hasPrevPage) {
                this.$emit('setPage', 'prev')
            }

            if (direction === 'first') {
                this.$emit('setPage', 'first')
            }

        }
    }
    
}
</script>