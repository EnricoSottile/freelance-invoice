<template>
    <div>

          <nav class="nav">
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

    .nav {
        @apply bg-white shadow-lg;
    }

    .nav-a {
        @apply p-6 font-light text-gray-700;
        transition: all .2s linear;
    }

    .router-link-active,
    .router-link-active:hover {
        @apply no-underline border-b-2 border-teal-500 text-teal-500;
        cursor:default;
        transition: all .2s linear;
    }

    .nav-a:hover:not(.router-link-active) {
        @apply no-underline bg-gray-100 border-b-2 border-gray-100 text-teal-500;
        cursor:pointer;
        transition: all .2s linear;
    }


</style>
