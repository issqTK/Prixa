<template>
    <div class="relative flex min-h-screen">
        <div class="fixed top-0 bottom-0 right-0 left-0 bg-gray-900 opacity-70 z-10" v-if="showingNavigation"
            @click="showingNavigation = !showingNavigation"></div>

        <nav :class="{ '!left-0': showingNavigation }"
            class="fixed top-0 -left-64 md:left-0 bottom-0 w-64 bg-sun-set bg-cover transition-all ease-in-out z-10 duration-700">
            <div class="absolute top-0 left-0 bottom-0 right-0 px-4" style="background:rgb(20, 19, 19,0.8);">
                <div class="my-4">
                    <Link :href="route('welcome')">
                    <img style="max-width:200px;" class="w-full mx-auto" src="/images/logos/logo2.png" alt="prixa"
                        draggable="false">
                    </Link>
                </div>

                <div class="mb-2">
                    <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        <span class="material-icons-round">dashboard</span>
                        <span>{{ trans.dashboard_nav_btn }}</span>
                    </BreezeNavLink>
                </div>

                <div class="mb-2">
                    <BreezeNavLink :href="route('ads')" :active="route().current('ads*')">
                        <span class="material-icons-outlined">campaign</span>
                        <span>{{ trans.manageAd_nav_btn }}</span>
                    </BreezeNavLink>
                </div>
                
                <div class="mb-2" v-if="$page.props.auth.user.admin == true">
                    <BreezeNavLink :href="route('listing')" :active="route().current('listing*')">
                        <span class="material-icons-outlined">list_alt</span>
                        <span>Listing</span>
                    </BreezeNavLink>
                </div>
            </div>
        </nav>

        <div class="w-64 hidden md:block"></div>

        <div class="flex-1 max-h-screen ">
            <header class="relative bg-white shadow flex items-center px-4 py-2 justify-between" v-if="$slots.header">

                <div class="flex gap-2 items-center">
                    <!-- hamburger -->
                    <div class="md:hidden">
                        <button @click="showingNavigation = !showingNavigation"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path
                                    :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <slot name="header" />
                </div>

                <BreezeDropdown align="right" width="48">
                    <template #trigger>
                        <div class="w-12 h-12 rounded-full border overflow-hidden">
                            <img :src="$page.props.auth.user.profile_picture ? '/images/profile/' + $page.props.auth.user.profile_picture : '/images/profile/profil_default.png'"
                                alt="" class="w-full">
                        </div>
                    </template>

                    <template #content>

                        <BreezeDropdownLink href="#" @click.prevent method="get" as="button">
                            {{ $page.props.auth.user.name }}
                        </BreezeDropdownLink>

                        <BreezeDropdownLink :href="route('profile.edit')" method="get" as="button">
                            {{ trans.profile_nav_btn }}
                        </BreezeDropdownLink>

                        <BreezeDropdownLink :href="route('ads')" method="get" as="button">
                            {{ trans.myAds_nav_btn }}
                        </BreezeDropdownLink>

                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                            {{ trans.logout_nav_btn }}
                        </BreezeDropdownLink>
                    </template>
                </BreezeDropdown>
            </header>

            <main>
                <slot />
            </main>
        </div>

    </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/vue3';
import { useWindowSize } from '@vueuse/core'

export default {
    setup() {
        const { width, height } = useWindowSize();
        return {
            windowWidth: width,
            windowHeight: height,
        };
    },
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
    },
    data() {
        return {
            showingNavigationDropdown: false,
            showingNavigation: false,
            trans: this.$page.props.lang.auth
        }
    },
    methods: {
        myEventHandler() {
            if (this.windowWidth >= 768 && this.showingNavigation == true) {
                this.showingNavigation = false
            }
        }
    },
    mounted() {

        /* axios
        .get('/api/get-user-pic').then(response => {
            this.pic = response.data;
        }); */
    },
    created() {
        window.addEventListener("resize", this.myEventHandler);
    },
}
</script>
<style>
input[type=text], input[type=number], textarea, select {
    font-size: .9em;
}
</style>