<template>
    <div>

          <nav class="nav px-2">
            <ul class="flex">
                <li class="flex">
                    <router-link class="nav-a-exact" :to="{ name: 'dashboard'}">
                        Home
                    </router-link>
                </li>
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
                <li class="flex dropdown-parent ml-auto">
                    <span>
                        submenu
                    </span>
                    <ul class="dropdown-menu">
                        <li>
                            <router-link :to="{ name: 'trash.index'}">
                                Trash
                                <span class="absolute right-0 mr-4 text-xs" v-html="getIcon('trash-2')"></span>
                            </router-link>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </nav>

    </div>
</template>

<script>    

    import UiCommonMethods from '@mixins/UiCommonMethods'

    export default {

        mixins: [ UiCommonMethods ],


    }
</script>

<style>

    .nav {
        @apply bg-white shadow-lg;
    }

    .nav-a,
    .nav-a-exact {
        @apply p-6 font-light text-gray-700 border-b-2 border-transparent;
        transition: all .2s linear;
    }

    .nav-a.router-link-active,
    .nav-a.router-link-active:hover {
        @apply no-underline border-b-2 border-teal-500 text-teal-500;
        cursor:default;
        transition: all .2s linear;
    }

    .nav-a-exact.router-link-exact-active,
    .nav-a-exact.router-link-exact-active:hover {
        @apply no-underline border-b-2 border-teal-500 text-teal-500;
        cursor:default;
        transition: all .2s linear;
    }

    

    .nav-a-exact:hover:not(.router-link-active),
    .nav-a:hover:not(.router-link-active) {
        @apply no-underline bg-gray-100 border-b-2 border-gray-100 text-teal-500;
        cursor:pointer;
        transition: all .2s linear;
    }

    .dropdown-parent > span {
        @apply p-6 font-light text-gray-700 border-b-2 border-transparent;        
    }

    .dropdown-parent {
        @apply flex relative;
    }


    .dropdown-parent:hover .dropdown-menu {
        display:block;
    }

    .dropdown-menu {
        position: absolute;
        top:100%;
        right: 0;
        margin-top: -2px; /* align border-top with others */
        background-color:white;
        min-width:100%;
        width: 300px;
        display:none;
        @apply shadow-lg border-t-2 border-teal-500;
    }

    .dropdown-menu li {
        display: block;
        @apply my-2;
    }

    .dropdown-menu li a {
        @apply relative block px-6 py-4  font-light text-gray-700;
    }

    .dropdown-menu li a.router-link-exact-active {
        @apply text-teal-500;
    }

    .dropdown-menu li a:hover {
        @apply no-underline bg-gray-100 text-teal-500;
    }

</style>
