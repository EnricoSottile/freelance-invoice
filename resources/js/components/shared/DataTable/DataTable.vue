<template>
    <div>

        <div class="mt-8 pt-4 border-gray-200 border-t-2">
           <div class="scrollable-container">

                <!-- TOOLBAR -->
                <div class="flex items-center px-6 mb-6">
                    <div class="paginate w-1/3">

                        <paginator-controls 
                            v-model="itemsPerPage"
                            :totalItems="totalItemsLength" 
                            :currentPage="currentPage"
                            :itemsPerPage="itemsPerPage"
                            :pages="pages"
                            @setPage="setPage($event)"></paginator-controls>                        

                    </div>
                    <div class="w-1/3"></div>
                    <div class="w-1/3 flex justify-end">

                        <div class="relative">
                            <search-input 
                                v-if="dataIsReady" 
                                :collection="collection" 
                                :fields="fields" 
                                @search="handleSearchResult($event)"></search-input>
                            <small v-if="searchResults" class="text-xs absolute font-light text-gray-600">Showing {{ getData.length }} results</small>
                        </div>

                    </div>
                </div>

                <!-- TABLE -->
                <table class="table table-sortable">
                <thead>
                    <tr>
                        <th v-for="field in fields" v-bind:key="field.name">
                            <button @click.prevent="sort(field.name)" :class="getSortedClass(field.name)">
                            {{ field.label }}
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="!dataIsReady">
                        <td :colspan="fields.length" rowspan="10" class="h-64">
                            <span class="text-xl">Loading</span>
                        </td>
                    </tr>
                    <tr v-else v-for="data in getData" v-bind:key="data[getFirstFieldProperty]">

                        <!-- <slot name="table-row"> -->
                            <td v-for="field in fields" v-bind:key="field.name">
                                <table-cell :field="field" :data="data"></table-cell>
                            </td>
                        <!-- </slot> -->

                    </tr>
                </tbody>
            </table>
           </div>
        </div>
        
    </div>
</template>

<script>
    import PaginatorControls from '@components/shared/PaginatorControls'
    import DataTableCell from './DataTableCell'
    import Search from '@components/shared/Search'
    import JSONSchema from './fieldsSchema'

    import _orderBy from 'lodash/orderBy'
    import _chunk from 'lodash/chunk'
    import _validateObject from '@helpers/validateObject'
    

    export default {

        components: {
            'table-cell': DataTableCell,
            'paginator-controls': PaginatorControls,
            'search-input': Search,
        },

        props: {
            dataIsReady: {
                type: Boolean,
                required: false,
                default: true,
            },
            collection: {
                type: Array,
                required: true
            },
            fields: {
                required: true,
                type: Array,
                validator(collection) {
                    return collection.every(field => _validateObject(field, JSONSchema));
                }
            }
        },

        data(){
            return {
                sortColumn: '',
                sortDirection: 'asc',
                searchResults: null, // [] only when search query.length,


                pages: 0,
                currentPage: 1,
                itemsPerPage: 25,
            }
        },

        created(){
            this.sortColumn = this.getFirstFieldProperty;
        },


        computed: {

            /**
             * Used in paginator-controls
             * returns the length of all items available
             * because doing getData.length returns number of chunks
             */
            totalItemsLength(){
                return (this.searchResults || this.collection).length
            },

            /**
             * helper method, use first item in collection as key
             * (usually id)
             */
            getFirstFieldProperty(){
                return this.fields[0].name;
            },

            /**
             * shows full collection of data || search results
             * the list is then ordered and paginated
             */
            getData(){
                // if search input is empty, 
                // 'this.searchResults' is always 'null'
                let data = this.searchResults || this.collection;
                const orderedData = this._orderData(data);
                
                //  'search' and sort, then paginate
                return this.paginate(orderedData);                
            },


        },

        methods: {
            paginate(data) {
                const chunks = _chunk(data, this.itemsPerPage);
                this.pages = chunks.length;

                if (!data.length) return data;

                return chunks[ this.currentPage -1 ];
            },

            setPage(param) {
                param === 'next' && this.currentPage++;
                param === 'prev' && this.currentPage--;
                
                if (param === 'first') this.currentPage = 1;
            },


            /**
             *  helper function, returns ordered data
             *  used in computed.getData
             */
            _orderData(data){
                const property = this.sortColumn;
                const order = this.sortDirection;
                return _orderBy(data, (c) => c[property], order);
            },
           
           /**
             *  unsort first, results are sorted by fuse.js
             */
            handleSearchResult(data) {
                this.unsort();
                this.currentPage = 1;
                this.searchResults = data;
            },


            /**
             *  onclick, set the column and direction of sort
             */
            sort(column){
                if (this.sortColumn === column) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortColumn = column;
                    this.sortDirection = 'asc';
                }
            },
            unsort(){
                this.sortColumn = '';
            },

            /**
             *  helper method to set the arrow css
             * @param {String} column
             */
            getSortedClass(column){
                if (this.sortColumn === column) {
                    return `sort-${this.sortDirection}`;
                }
            },

        },


        
    }
</script>

<style>
    .scrollable-container {
        max-height:65vh;
        overflow: scroll;
    }
    .table {
        width: 100%;
        @apply mt-4;
    }
    .table > thead > tr,
    .table > tbody > tr {
        @apply border-b border-gray-300;
        transition: all .1s linear;
    }


    .table > tbody > tr:hover {
        @apply bg-gray-100;
    }

    .table th,
    .table td {
        @apply py-4 px-8 text-gray-700;
    }

    .table th,
    .table th button {
        @apply font-semibold;
    }

    .table td {
        @apply font-light;
        text-align:center;
    }

    .table-sortable > thead > tr > th {
        position:relative;
    }

    .table-sortable .sort-asc,
    .table-sortable .sort-desc {
        @apply text-teal-500;
    }

    .table-sortable .sort-asc:after,
    .table-sortable .sort-desc:after {
        position:absolute;
        display: inline-block;
    }


    .table-sortable .sort-asc:after {
        content: '\2191';
    }

    .table-sortable .sort-desc:after {
        content: '\2193';
    }

    .table-sortable > thead > tr > th.paginate {
        text-align:left;
    }

    .table-sortable th.paginate > span {
         @apply font-medium text-teal-500;

    }

    .table-sortable th.paginate a {
        @apply text-gray-500 font-light;
    }

    .table-sortable th.paginate a:hover {
        @apply text-teal-500;
    }

</style>