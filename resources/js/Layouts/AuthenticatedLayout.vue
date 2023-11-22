<template>
    <div class="relative flex min-h-screen">
        <div 
            v-if="showingNavigation"
            @click="showingNavigation = !showingNavigation" 
            class="fixed top-0 bottom-0 right-0 left-0 bg-zinc-900 opacity-40 z-10"
        ></div>

        <nav :class="{ '!left-0': showingNavigation }" class="fixed w-64 -left-64 md:left-0 top-0 bottom-0 transition-all ease-in-out duration-700 z-10 bg-sun-set bg-cover" >
            <div class="absolute top-0 left-0 bottom-0 right-0 px-4" style="background:rgb(20, 19, 19,0.8);">
                <!-- Logo -->
                <div class="my-4">
                    <Link :href="route('welcome')">
                        <img src="/images/logos/logo2.png"
                            draggable="false"
                            class="w-full mx-auto" 
                            style="max-width:200px;" 
                        >
                    </Link>
                </div>

                <!-- Dashboard nav item -->
                <div class="mb-2">
                    <BreezeNavLink 
                        :href="route('dashboard')" 
                        :active="route().current('dashboard')">

                        <span class="material-icons-round">dashboard</span>
                        <span>{{ trans.primary_nav_dashboard }}</span>
                    </BreezeNavLink>
                </div>

                <!-- Ads nav item -->
                <div class="mb-2">
                    <BreezeNavLink 
                        :href="route('ads')" 
                        :active="route().current('ads*')">

                        <span class="material-icons-outlined">campaign</span>
                        <span>{{ trans.primary_nav_ads }}</span>
                    </BreezeNavLink>
                </div>
                
                <!-- listing nav item -->
                <div class="mb-2" v-if="$page.props.auth.user.admin == true">
                    <BreezeNavLink 
                        :href="route('listing')" 
                        :active="route().current('listing*')">
                        
                        <span class="material-icons-outlined">list_alt</span>
                        <span>{{trans.primary_nav_listing}}</span>
                    </BreezeNavLink>
                </div>
            </div>
        </nav>

        <div class="w-64 hidden md:block"></div>

        <div class="flex-1 max-h-screen ">
            <header v-if="$slots.header" class="relative flex items-center justify-between px-4 py-2 bg-white shadow">
                <div class="flex gap-2 items-center">
                    <button @click="showingNavigation = !showingNavigation"
                        class="md:hidden flex items-center justify-center p-2 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 transition duration-300 ease-in-out">
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

                    <slot name="header" />
                </div>

                <BreezeDropdown width="48">
                    <template #trigger>
                        <div class="w-11 h-11 rounded-full ring-2 ring-zinc-100 overflow-hidden">
                            <img class="w-full"
                                :src="$page.props.auth.user.profile_picture ? '/images/profile/' + $page.props.auth.user.profile_picture : '/images/profile/profil_default.png'"
                            >
                        </div>
                    </template>

                    <template #content>
                        <span class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                            {{ $page.props.auth.user.name }}
                        </span>

                        <BreezeDropdownLink :href="route('ads')" method="get" as="button">
                            {{ trans.modal_content_ads }}
                        </BreezeDropdownLink>

                        <BreezeDropdownLink :href="route('profile.edit')" method="get" as="button">
                            {{ trans.modal_content_profile }}
                        </BreezeDropdownLink>

                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                            {{ trans.modal_content_logout }}
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

<script setup>
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import { Link, usePage } from '@inertiajs/vue3';
import { useWindowSize } from '@vueuse/core';
import { ref } from 'vue';

const { width, height } = useWindowSize();

const trans = usePage().props.lang.authLayout;

const showingNavigationDropdown =  ref(false);

const showingNavigation = ref(false);

const myEventHandler = () => {
    if (width >= 768 && showingNavigation == true) {
        showingNavigation.value = false;
    }
}
window.addEventListener("resize", myEventHandler);
</script>

<style> input[type=text], input[type=number], textarea, select { font-size: .9em; } </style>