<template>
    <div>
        Trash show <br/>

        res: {{ resource }} <br/>
        id: {{ trashedId }} <br/>


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


        methods: {
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
                SweetAlert.fire('Deleted!', `The invoice has been deleted.`, 'success');
                router.go(-1)
            }
        }


    }
</script>