
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
                const resource = data.full_name ? 
                                    'customer' : data.number ? 
                                        'invoice' : 'payment';
                return {
                    resource,
                    trashedId: data.id
                }
            }
        }
    },
    {
        name: 'type', 
        label: 'type',
        display: (data) => {
            return data.full_name ? 
                'customer' : data.number ? 
                    'invoice' : 'payment';
        },
    },
    {
        name: 'name', 
        label: 'identifier',
        display: (data) => {
            return data.full_name || data.number || '';
        },
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