<template>
    <div
        class="min-h-screen flex flex-col items-center bg-dots-darker bg-center bg-gray-100 bg-fixed selection:bg-red-500 selection:text-white"
    >
        <div
            class="flex flex-row items-center justify-between w-full sm:max-w-2xl sm:rounded-md bg-white p-4 border"
        >
            <Link href="/">
                <img
                    style="width: 150px"
                    src="/images/logos/logo.png"
                    alt="prixa"
                    draggable="false"
                />
            </Link>

            <div v-if="$page.props.auth.user">
                <div class="flex mx-auto gap-2 items-center sm:gap-4 sm:mx-0">
                    <BreezeNavLinkTop
                        :href="route('search')"
                        :active="route().current('search')"
                    >
                        <svg
                            :class="{'!stroke-slate-50': route().current('search')}"
                            class="hidden sm:inline stroke-slate-700 group-hover:stroke-slate-50"
                            height="26"
                            width="26"
                            fill="none"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            style="fill: transparent; stroke-width: 0"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                        <span>{{ trans.search_nav_btn }}</span>
                    </BreezeNavLinkTop>

                    <BreezeNavLinkTop :href="route('dashboard')">
                        <svg
                            class="hidden sm:inline fill-slate-700 group-hover:fill-slate-50"
                            height="26"
                            width="26"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            style="stroke-width: 0"
                        >
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                            />
                        </svg>
                        <span>{{ trans.dashboard_nav_btn }}</span>
                    </BreezeNavLinkTop>

                    <BreezeDropdown align="right" width="48">
                        <template #trigger>
                            <div
                                class="w-12 h-auto rounded-full border overflow-hidden cursor-pointer"
                            >
                                <img
                                    :src="
                                        $page.props.auth.user.profile_picture
                                            ? '/images/profile/' +
                                              $page.props.auth.user
                                                  .profile_picture
                                            : '/images/profile/profil_default.png'
                                    "
                                    alt=""
                                    class="w-full"
                                />
                            </div>
                        </template>

                        <template #content>
                            <BreezeDropdownLink
                                href="#"
                                @click.prevent
                                method="get"
                                as="button"
                            >
                                {{ $page.props.auth.user.name }}
                            </BreezeDropdownLink>

                            <BreezeDropdownLink
                                :href="route('profile.edit')"
                                method="get"
                                as="button"
                            >
                                {{ trans.profile_nav_btn }}
                            </BreezeDropdownLink>

                            <BreezeDropdownLink
                                :href="route('ads')"
                                method="get"
                                as="button"
                            >
                                {{ trans.myAds_nav_btn }}
                            </BreezeDropdownLink>

                            <BreezeDropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                {{ trans.logout_nav_btn }}
                            </BreezeDropdownLink>
                        </template>
                    </BreezeDropdown>
                </div>
            </div>
            <div v-else>
                <div class="flex mx-auto gap-2 sm:gap-4 sm:mx-0">
                    <BreezeNavLinkTop
                        :href="route('search')"
                        :active="route().current('search')"
                    >
                        <svg
                            :class="{
                                '!stroke-slate-50': route().current('search'),
                            }"
                            class="hidden sm:inline stroke-slate-700 group-hover:stroke-slate-50"
                            height="26"
                            width="26"
                            fill="none"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            style="fill: transparent; stroke-width: 0"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                        <span>{{ trans.search_nav_btn }}</span>
                    </BreezeNavLinkTop>

                    <BreezeNavLinkTop
                        :href="route('login')"
                        :active="route().current('login')"
                    >
                        <svg
                            :class="{'!fill-slate-50': route().current('login')}"
                            class="hidden sm:inline fill-slate-700 group-hover:fill-slate-50"
                            height="26"
                            width="26"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            style="stroke-width: 0"
                        >
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2a7.2 7.2 0 01-6-3.22c.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08a7.2 7.2 0 01-6 3.22z"
                            ></path>
                        </svg>
                        <span>{{ trans.login_nav_btn }}</span>
                    </BreezeNavLinkTop>

                    <BreezeNavLinkTop
                        :href="route('guest.createAd')"
                        :active="route().current('guest.createAd')"
                        class="min-w-max"
                    >
                        <svg
                            :class="{'!fill-slate-50': route().current('guest.createAd')}"
                            class="hidden sm:inline fill-slate-700 group-hover:fill-slate-50"
                            height="26"
                            width="26"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            style="stroke-width: 0"
                        >
                            <path
                                d="M9.3 4h5.4l1.647 1.778H19.2c.99 0 1.8.8 1.8 1.778v10.666C21 19.2 20.19 20 19.2 20H4.8c-.99 0-1.8-.8-1.8-1.778V7.556c0-.978.81-1.778 1.8-1.778h2.853L9.3 4zM12 17.333c2.484 0 4.5-1.99 4.5-4.444 0-2.453-2.016-4.445-4.5-4.445s-4.5 1.992-4.5 4.445c0 2.453 2.016 4.444 4.5 4.444zm0-1.777c1.491 0 2.7-1.194 2.7-2.667 0-1.473-1.209-2.667-2.7-2.667s-2.7 1.194-2.7 2.667c0 1.473 1.209 2.667 2.7 2.667z"
                            ></path>
                        </svg>
                        <span>{{ trans.createAd_nav_btn }}</span>
                    </BreezeNavLinkTop>
                </div>
            </div>
        </div>

        <div
            class="w-full sm:max-w-2xl mt-6 bg-white shadow-md overflow-hidden sm:rounded-md"
        >
            <Carossel v-if="route().current('welcome')"></Carossel>
            <div class="px-8 py-6">
                <slot />
            </div>
        </div>
    </div>
</template>

<script>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import BreezeNavLinkTop from "@/Components/customNavLinkTop.vue";

import { Link } from "@inertiajs/vue3";
import Carossel from "@/Components/Carossel.vue";

export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLinkTop,
        Link,
        Carossel,
    },
    data() {
        return {
            trans: this.$page.props.lang.auth,
        };
    },
};
</script>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
