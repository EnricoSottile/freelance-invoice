<template>
    <div>

          <nav class="bg-gray-600 shadow-lg">
            <ul class="flex">
                <li class="flex">
                    <router-link class="nav-a" :to="{ name: 'customer.index'}">
                        Customers
                    </router-link>
                </li>
                <li class="flex">
                    <router-link class="nav-a" :to="{ name: 'invoice.index'}">
                        Invoices
                    </router-link>
                </li>
                <li class="flex">
                    <router-link class="nav-a" :to="{ name: 'payment.index'}">
                        Payments
                    </router-link>
                </li>
            </ul>
        </nav>

    </div>
</template>

<script>    

    export default {



    }
</script>

<style>


    .nav-a {
        @apply p-6 text-white uppercase font-semibold text-xs;
    }

    .nav-a:hover,
    .router-link-active {
        @apply no-underline text-gray-600 bg-gray-300;
    }


</style>
