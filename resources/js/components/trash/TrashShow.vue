<template>
    <div>
        Trash show <br/>

        res: {{ resource}} <br/>
        id: {{ trashedId }} <br/>
        

    </div>
</template>

<script>

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
        }


    }
</script>