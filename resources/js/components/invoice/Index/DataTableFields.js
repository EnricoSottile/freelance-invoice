
/**
 * Fields used to build the datatable
 * 
 * 
 */ 
export default [
    {name: 'id', label: 'Id'},
    {name: 'number', label: 'Number'},
    {
        name: 'full_name', 
        label: 'Customer',
        link: {
            view: 'customer.show',
            params: {name: 'customerId', property: 'customer_id'}
        }
    },
    {
        name: 'net_amount', 
        label: 'Net amount',
        money: {
            // Intl.NumberFormat options
            // locale: 'ja-JP',
            // moneyOptions: {
            //     style: 'currency', currency: 'JPY'
            // }
        },
    },
    {
        name: 'tax', 
        label: 'Tax',
        percent: true,
    },
    {
        name: 'description', 
        label: 'Description',
    },
    {
        name: 'date', 
        label: 'Date',
        date: {}
    },
    {
        name: 'sent_date', 
        label: 'Sent',
        date: {}
    },
    {
        name: 'registered_date', 
        label: 'Registered',
        date: {}
    }
];


