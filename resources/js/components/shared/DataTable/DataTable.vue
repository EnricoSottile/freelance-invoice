<template>
    <div>

        <div class="scrollable-container">
            <table class="table table-sortable">
                <thead>
                    <tr>
                        <th :colspan="fields.length">
                            <search-input 
                            v-if="dataIsReady" 
                            :collection="collection" 
                            :fields="fields" 
                            @search="handleSearchResult($event)"></search-input>
                            <small v-if="searchResults" class="text-xs font-light text-gray-600">Showing {{ getSortedData.length }} results</small>
                        </th>
                    </tr>
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
                            Loading
                        </td>
                    </tr>
                    <tr v-else v-for="data in getSortedData" v-bind:key="data[getFirstFieldProperty]">
                        <td v-for="field in fields" v-bind:key="field.name">

                            <template v-if="field.link ">
                                <router-link 
                                    :to="getLinkOptions(field.link, data)">
                                    {{ getContent(data, field) }}
                                </router-link>
                            </template>

                            <template v-else-if="field.date ">
                                {{ formatDate(field.date, getContent(data, field))}}
                            </template>

                            <template v-else>{{ getContent(data, field) }}</template>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</template>

<script>
    import _formatDate from '@helpers/formatDate'
    import _orderBy from 'lodash/orderBy'
    import _validateObject from '@helpers/validateObject'
    import _moneyFormat from '@helpers/moneyFormat'
    import Search from '@components/shared/Search'
    import JSONSchema from './fieldsSchema'

    export default {

        components: {
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
                validator(value) {
                    return value.every(field => _validateObject(field, JSONSchema));
                }
            }
        },

        data(){
            return {
                sortColumn: '',
                sortDirection: 'asc',
                searchResults: null, // [] only when search query.length
            }
        },

        mounted(){
            this.sortColumn = this.getFirstFieldProperty;
        },


        computed: {
            /**
             * helper method, use first item in collection as key
             * (usually id)
             */
            getFirstFieldProperty(){
                return this.fields[0].name;
            },
            getSortedData(){
                const property = this.sortColumn;
                const order = this.sortDirection;
                const data = this.searchResults !== null ? this.searchResults : this.collection;
                return _orderBy(data, (c) => c[property], order);
            },
        },

        methods: {
           
           /**
             *  unsort first, results are sorted by fuse.js
             */
            handleSearchResult(data) {
                this.unsort();
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


            /**
             * construct the object needed for the router-link .to
             * ie: {name: 'customer.show', params: {customerId: customer.id}}
             * 
             * @param {Object} link 
             * @param {Object} data
             */ 
            getLinkOptions(link, data){
                return {
                    name: link.view,
                    params: {
                        [link.params.name]: data[link.params.property]
                    }
                }
            },

            formatDate(options, value) {
                return _formatDate(options, value)
            },

            moneyFormat(digits, options) {
                return _moneyFormat(digits, options);
            },



            getContent(data, field) {
                let content = data[field.name];
                if (!content || !content.length) return content;

                if (content.length > 25) {
                    content = content.substr(0, 25) + "...";
                }

                if (field.percent) {
                    content += '%';
                }

                if (field.money) {
                    content = this.moneyFormat(content, field.money);
                }

                return content;
            }
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

    .table > thead > tr:first-child {
        @apply border-0;
    }

    .table > thead > tr:first-child > th {
        @apply text-right;
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
</style>