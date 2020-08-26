# freelance-invoice
A simple web app to manage customers, invoices and payments as a freelancer.   
**IMPORTANT: This project is on hold**

## description
The main purpose of the application is to help manage the boring part of freelancing (invoicing, keeping track of payments..)
in a simpler, intuitive way. It currently features Datatables, a gallery/upload component and trash/restore functionality 
(cascade delete/restore under development).

The second main purpose of this project is to help me gain a better understanding of some programming concepts so expect a lot of code refactoring


## tech
- Frontend: Vue+vueRouter and features reusable components, ES6 classes and more interesting stuff.
- Css: just tailwind
- Backend: Laravel/mysql
- Tests: need to be fixed/updated (phpunit, jest) 
- Data validation: backend only (the error are still reported to the frontend) - Frontend validation will be added later

## how to use
1. Follow the common Laravel setup (composer install, set .env parameters, create db...)
2. migrate and seed the database `php artisan migrate --seed`
3. launch the webserver and navigate to customers/invoices/payments to try the app


## screenshots
#### Index
![screenshot-1]


#### Show/Edit
![screenshot-2]


[screenshot-1]: https://raw.githubusercontent.com/EnricoSottile/freelance-invoice/master/screenshot-1.png
[screenshot-2]: https://raw.githubusercontent.com/EnricoSottile/freelance-invoice/master/screenshot-2.png
