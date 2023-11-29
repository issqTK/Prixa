<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Layouts/GuestLayout.vue";

defineProps(["ads", "listings"]);

defineOptions({
    layout: Layout,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="flex flex-col gap-4 mb-8">
        <h2 class="text-2xl font-bold">{{__('New Arrivals')}}</h2>

        <div v-if="ads.length > 0" id="latest" class="flex flex-wrap justify-start items-start p-4">
            <Link
                v-for="(ad, index) in ads"
                :key="index"
                :href="route('ad.view', ad.slug)"
                class="sclale-100 motion-safe:hover:scale-[1.01] transition-all duration-250 flex flex-col justify-start items-center gap-2 p-3 text-center text-black bg-white shadow hover:shadow-lg focus:outline focus:outline-2 focus:outline-red-500 rounded cursor-pointer"
            >
                <h3
                    class="w-full text-base font-semibold text-gray-900 whitespace-nowrap text-ellipsis overflow-hidden dark:text-white capitalize"
                >
                    {{ ad.title }}
                </h3>

                <div
                    class="relative w-full sm:w-11/12 h-24 sm:h-28 md:h-32 overflow-hidden rounded"
                >
                    <img
                        v-if="/^http/.test(ad.images[0].source)"
                        :src="ad.images[0].source"
                        class="absolute"
                        alt="default product image"
                    />
                    <img
                        v-else
                        :src="'/storage/images/ads/' + ad.images[0].source"
                        class="absolute"
                        alt="default product image"
                    />
                </div>

                <p class="w-full">
                    <span class="font-bold text-sky-500">
                        {{ ad.price }} DH
                    </span>
                </p>

                <p
                    class="description w-full h-10 text-gray-700 dark:text-gray-400 text-sm leading-relaxed overflow-hidden"
                >
                    {{ ad.description }}
                </p>
            </Link>
        </div>
        
        <div v-else>{{__('No Ads To List Yet!')}}</div>
    </div>

    <div class="flex flex-col gap-4">
        <h2 class="text-2xl font-bold">{{__('Which phone is right for you?')}}</h2>

        <div v-if="listings.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-4">
            <Link
                v-for="(listing, index) in listings"
                :key="index"
                :href="route('listing.view', listing.slug)"
                style="min-height: 300px"
                class="p-6 rounded-lg shadow hover:shadow-lg flex gap-4 scale-100 motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 cursor-pointer"
            >
                <div class="flex flex-col gap-1.5 w-full flex-1">
                    <div class="flex items-center gap-4">

                        <img :src="'/storage/images/listings/' + listing.avatar" draggable="false" class="h-16 w-16"/>

                        <h2 class="font-semibold text-gray-900 dark:text-white"> {{ listing.title }} </h2>
                    </div>

                    <p
                        class="mt-4 text-gray-700 dark:text-gray-400 text-sm leading-relaxed flex flex-col justify-between gap-1 flex-1"
                    >
                        {{ listing.description_header }}
                    </p>
                </div>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    class="self-center shrink-0 stroke-red-500 w-6 h-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                    />
                </svg>
            </Link>
        </div>

        <div v-else>{{ __('No Listings To List Yet!') }}</div>
    </div>
</template>

<style scoped>
#latest {
    gap: 5%;
    row-gap: 25px;
}
#latest a {
    width: 30%;
}
#latest img {
    min-width: 100%;
    min-height: 100%;
    top: 50%;
    left: 50%;
    object-fit:cover;
    transform: translate(-50%, -50%);
}
.description {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
</style>
