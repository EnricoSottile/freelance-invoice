
/**
 * Fields used to build the datatable
 * no additional argument passed (such as date, or money)
 * because payment component extends the datatable through <slot>
 * 
 */ 
export default [
    {name: 'id', label: 'Id'},
    {name: 'invoice_number', label: 'Invoice'},
    {name: 'net_amount', label: 'Amount'},
    {name: 'due_date', label: 'Due'},
    {name: 'payed_date', label: 'Payed'},
    {name: 'created_at', label: 'Created'},
];



