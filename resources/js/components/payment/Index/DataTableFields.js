
/**
 * Fields used to build the datatable
 * no additional argument passed (such as date, or money)
 * because payment component extends the datatable through <slot>
 * 
 */ 
export default [
    {
        name: 'id', 
        label: 'Id'
    },
    {
        name: 'invoice_number', 
        label: 'Invoice',
        link: {
            view: 'invoice.show',
            params: {name: 'invoiceId', property: 'invoice_id'}
        }
    },
    {name: 'net_amount', label: 'Amount', money: {} },
    {name: 'due_date', label: 'Due', date: {} },
    {name: 'payed_date', label: 'Payed', date: {} },
    {name: 'created_at', label: 'Created', date: {} },
];



