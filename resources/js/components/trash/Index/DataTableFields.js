

/**
 * Fields used to build the datatable
 * 
 * 
 */ 
export default [
    {
        name: 'id', 
        label: 'Id',
        link: {
            view: 'trash.show',
            params: (data) => {
                return {
                    resource: data.type,
                    trashedId: data.id
                }
            }
        }
    },
    {
        name: 'type', 
        label: 'type'
    },
    {
        name: 'identifier', 
        label: 'identifier',
    },
    {
        name: 'deleted_at', 
        label: 'Deleted',
        date: {
            // default toLocaleDateString options
            // locale: 'it-IT',
            // weekday: 'short', 
            // year: 'numeric', 
            // month: 'long', 
            // day: 'numeric'
        }
    },
];