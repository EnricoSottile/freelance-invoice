<template>
    <div>


        <div class="flex mt-10 justify-between">
            <h1 class="font-light text-2xl">trash</h1>


        </div>


        <data-table 
            :collection="trashed" 
            :fields="fields" 
            :dataIsReady="trashedAreReady">
        </data-table>

    </div>
</template>

<script>
    import _moneyFormat from '@helpers/moneyFormat'
    
    // import Customer from '@classes/Customer'
    import DataTable from '@components/shared/DataTable/DataTable'
    import DataTableFields from './DataTableFields'

    

    export default {

        components: {
            'data-table': DataTable,
        },

        
        created(){
            this.getTrashed();
        },

        beforeRouteUpdate (to, from, next) {
            this.getTrashed();
            next();
        },


        data(){
            return {
                // customerClass: Customer,
                trashed: [],
                trashedAreReady: false,

                fields: DataTableFields,
            }
        },



        methods: {
            async getTrashed(){
                const { data } = await axios.get('app/trash/index');
                const preparedData = this.prepareData( data );
                this.trashed = preparedData;
                this.trashedAreReady = true;
            },

            /** 
            * sets the type inside the item using the array key
            * and flatten the object to a datatable readied array
            * 
            * @param {Object} dataObj an object of collections
            * ['customers' => $customers, 'invoices' => $invoices, ....]
            * 
            */
            prepareData(dataObj) {        
                let data = [];
                for (const key of Object.keys(dataObj) ) {
                    const collection = dataObj[key];

                    const items = collection.forEach(item => {
                        data.push({
                            id: item.id,
                            type: key,
                            identifier: item.full_name || item.number || _moneyFormat(item.net_amount, {}),
                            deleted_at: item.deleted_at
                        });
                    })

                }

                return data;
            }
        },
    }
</script>

