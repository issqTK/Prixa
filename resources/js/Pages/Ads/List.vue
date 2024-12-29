<template>
    <Head :title="__('Manage Ads')" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-black leading-tight">
                {{ __('Ads Manager') }}
            </h1>
        </template>

        <div class="py-9">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="content">
                <!--success message-->
                <div
                    v-if="$page.props.flash.success"
                    class="w-full rounded mb-4 p-6 text-center text-base bg-emerald-500 text-white font-semibold"
                >
                    {{ $page.props.flash.success }}
                </div>

                <div class="relative overflow-hidden rounded sm:rounded-lg shadow sm:shadow-xl mb-4" >
                    <h2 class="flex items-center gap-3 px-4 py-3 text-xl font-bold bg-zinc-200">
                        <span class="material-icons-outlined">featured_play_list</span>
                        {{ __('Ads List') }}
                    </h2>

                    <Link :href="route('ads.create')"
                        class="absolute top-1.5 right-4 inline-flex items-center justify-center gap-2 py-2 px-4 text-xs font-bold tracking-wide uppercase hover:bg-zinc-950 bg-transparent text-zinc-950 hover:text-zinc-50 transition-all easy-in-out rounded border border-zinc-950">
                    
                        <span class="material-icons-outlined min-w-min">playlist_add</span>
                        {{ __('New Ad') }}
                    </Link>

                    <div v-if="displayAds.data && displayAds.data.length !== 0" class="py-4 px-6 flex flex-col gap-4">
                        <div v-for="ad in displayAds.data" :key="ad.id"
                            class="relative cursor-pointer rounded overflow-hidden border border-zinc-100" >
                            
                            <!-- Actions -->
                            <div class="absolute top-0 bottom-0 left-0 right-0 flex">
                                <div class="w-6/12 flex group">
                                    <Link 
                                        :href="route('ads.edit', ad.id)"
                                        class="w-full hidden group-hover:flex items-center justify-center bg-zinc-900 opacity-90 animate-pulse transition-all font-bold text-white capitalize rounded-l">
                                        {{ __('Click To Edit') }}
                                    </Link>
                                </div>

                                <div class="w-6/12 flex group">
                                    <button @click.prevent="deletAd(ad.id)"
                                        class="w-full hidden group-hover:flex items-center justify-center bg-rose-700 opacity-90 animate-pulse transition-all font-bold text-white capitalize rounded-r"
                                    >
                                    {{ __('Click To Delete') }}
                                    </button>
                                </div>
                            </div>

                            <h3 class="text-base font-semibold capitalize p-2 sm:px-4 md:px-6 rounded-t mb-1 bg-zinc-100">
                                {{ ad.title }}
                            </h3>

                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 py-1 justify-center mx-4">
                                <div class="flex items-center">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-3 w-3 md:h-4 md:w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"
                                        />
                                    </svg>
                                    <span class="ml-1 md:ml-2 text-sm md:text-md font-semibold">{{ ad.product }}</span>
                                </div>
                                
                                <div class="flex justify-end items-center">
                                    <span class="ml-1 md:mr-2 text-sm md:text-md font-semibold">{{ ad.city }}</span>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-3 w-3 md:h-4 md:w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                </div>
                                
                                <div class="flex justify-end items-center">
                                    <span class="ml-1 md:mr-2 text-sm md:text-md font-semibold" >{{ ad.images }}</span>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-3 w-3 md:h-4 md:w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>

                                <div class="absolute top-2 right-2 sm:static flex justify-end items-center">
                                    <div v-if="ad.state == 'Pending'" class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full border-2 border-amber-400 ring-2 ring-amber-300"></span>
                                        <span class="text-xs font-semibold text-amber-400">{{ __('Pending') }}</span>
                                    </div>
                                    
                                    <div v-if="ad.state == 'Valid'" class="flex items-center justify-end gap-2">
                                        <span class="w-2 h-2 rounded-full border-2 border-emerald-500 ring-2 ring-emerald-400"></span>
                                        <span class="text-xs font-semibold text-emerald-500">{{ __('Valid') }}</span>
                                    </div>

                                    <div v-if="ad.state == 'Rejected'" class="flex items-center justify-end gap-2">
                                        <span class="w-2 h-2 rounded-full border-2 border-red-500 ring-2 ring-red-400"></span>
                                        <span class="text-xs font-semibold text-red-500">{{ __('Rejected') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4" v-else>{{ __('No Ads To List Yet!') }}</div>
                </div>

                <TailwindPagination
                    :data="displayAds"
                    @pagination-change-page="getResults"
                />
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { Head, Link, usePage, router } from "@inertiajs/vue3";
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { TailwindPagination } from "laravel-vue-pagination";

const props = defineProps(['areYouSure']);

const page = usePage();

const deletAd = (ad) => {
    router.delete(route('ads.delete', ad), {
        preserveState: true,
        onBefore: () => confirm(props.areYouSure),
        onSuccess: () => {
            setTimeout(() => { page.props.flash.success = null }, 2500);
            getResults();
        }
    });
}

const displayAds = ref({ data: [] });

const getResults = (page = 1) => {
    axios.get("/sanctum/csrf-cookie").then((response) => {
        axios
            .get(`/api/list-ads?page=${page}`)
            .then((response) => {
                displayAds.value = response.data;
            })
            .then(() => {
                document
                    .getElementById("content")
                    .scrollIntoView({ behavior: "smooth" });
            });
    });
};

getResults();
</script>