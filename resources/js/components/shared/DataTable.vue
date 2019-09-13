<template>
    <div>

        <table class="table table-sortable">
            <thead>
                <tr class="thead-row">
                    <th v-for="field in fields" v-bind:key="field.name">
                        <button @click.prevent="sort(field.name)" :class="getSortedClass(field.name)">
                        {{ field.label }}
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!dataIsReady">
                    <td colspan="5" rowspan="10" class="h-64">
                        Loading
                    </td>
                </tr>
                <tr v-else v-for="data in getSortedData" v-bind:key="data[getFirstFieldProperty]">
                    <td v-for="field in fields" v-bind:key="field.name">

                        <template v-if="field.options && field.options.type === 'link' ">
                            <router-link 
                                :to="{name: field.options.view, params: getParams(field.options.params, data)}">
                                {{ data[field.name] }}
                            </router-link>
                        </template>


                        <template v-else-if="field.options && field.options.type === 'date' ">
                            {{ formatDate(field.options, data[field.name])}}
                        </template>

                        <template v-else>{{ data[field.name] }}</template>
                        
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
</template>

<script>
    import _orderBy from 'lodash/orderBy'

    export default {

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
                validator(value) {
                    // match atleast [{name: '', label: ''}]
                    return Array.isArray(value) && value.every(field => {
                        return field.name && field.label;
                    })
                }
            }
        },

        data(){
            return {
                    sortColumn: '',
                    sortDirection: 'asc',
            }
        },

        mounted(){
            this.sortColumn = this.getFirstFieldProperty;
        },

        computed: {
            /**
             *  helper method, use first item in collection as key
             * (usually id)
             */
            getFirstFieldProperty(){
                return this.fields[0].name;
            },
            getSortedData(){
                const property = this.sortColumn;
                const order = this.sortDirection;
                return _orderBy(this.collection, (c) => c[property], order);
            },
        },

        methods: {
            
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
             * construct the object needed for the router-link to.params
             * ie: {customerId: customer.id}
             * 
             * @param {Object} params 
             * @param {Object} data
             */ 
            getParams(params, data) {
                return {[params.name]: data[params.property]};
            },

            /**
             * date format with defaults
             * 
             * @param {Object} options 
             * @param {String} value
             */ 
            formatDate(options, value) {
                const locale = options.locale || 'en-US';
                const dateOptions = options.dateOptions || {
                                 weekday: 'short', 
                                 year: 'numeric', 
                                 month: 'long', 
                                 day: 'numeric'
                            };
                return new Date(value).toLocaleDateString(locale, dateOptions);
            }
        },


        
    }
</script>

<style>
    .table {
        width: 100%;
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
        text-align:center;
    }

    .table th,
    .table th button {
        @apply font-semibold;
    }

    .table td {
        @apply font-light;
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