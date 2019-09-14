
/**
 * Fields used to build the datatable
 * 
 * 
 */ 
export default [
    {name: 'id', label: 'Id'},
    {
        name: 'full_name', 
        label: 'Name',
        link: {
            view: 'customer.show',
            params: {name: 'customerId', property: 'id'}
        }
    },
    {name: 'email', label: 'Email'},
    {name: 'phone', label: 'Phone'},
    {name: 'vat_code', label: 'Vat'},
    {
        name: 'created_at', 
        label: 'Created',
        ciao: 'bao',
        date: {
            // default toLocaleDateString options
            // dateOptions: {
            //     weekday: 'short', 
            //     year: 'numeric', 
            //     month: 'long', 
            //     day: 'numeric'
            // }
        }
    },
];