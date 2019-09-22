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

                this.trashed = data;
                this.trashedAreReady = true;
            }
        },
    }
</script>

