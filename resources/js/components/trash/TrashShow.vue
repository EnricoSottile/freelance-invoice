<template>
    <div>
        Trash show <br/>

        res: {{ resource }} <br/>
        id: {{ trashedId }} <br/>


        <pre>
            {{ trashed }}
        </pre>


        <button @click="restore">restore</button>
        <button @click="destroy">delete forever</button>
        

    </div>
</template>

<script>
    import SweetAlert from '@classes/SweetAlert'
    import Trash from '@classes/Trash'

    export default {

        props: {
            resource: {
                required: true,
                type: [String, Number]
            },
            trashedId: {
                required: true,
                type: [String, Number]
            },
        },


        created(){
            this.getTrashedItem(this.resource, this.trashedId);
        },

        beforeRouteUpdate (to, from, next) {
            const resource = to.params.resource
            const trashedId = to.params.trashedId;
            this.getTrashedItem(resource, trashedId);
            next();
        },

        data(){
            return {
                trashed: '',
            }
        },


        methods: {
            async getTrashedItem(resource, trashedId){
                const { data } = await Trash.show(resource, trashedId);
                this.trashed = data;
                this.trashedIsReady = true;
            },
            async restore(){
                const canRestore = await SweetAlert.confirmRestore(this.resource);
                if (canRestore === false) return;

                const response = await Trash.restore(this.resource, this.trashedId)
                SweetAlert.fire('Restored!', `The ${this.resource} has been restored.`, 'success');
                router.go(-1)
            },
            async destroy(){
                const canDelete = await SweetAlert.confirmDelete(this.resource, {
                    text: `This ${this.resource} will be permanently deleted and will not be recoverable`,
                    confirmButtonText: 'Yes, delete it forever'
                });
                if (canDelete === false) return;

                const response = await Trash.destroy(this.resource, this.trashedId)
                SweetAlert.fire('Deleted!', `The ${this.resource} has been deleted.`, 'success');
                router.go(-1)
            }
        }


    }
</script>