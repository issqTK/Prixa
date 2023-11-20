<template>
    <Head :title="listing.meta_title" />
    <Head :description="listing.meta_description" />

    <h1 class="text-gray-900 text-2xl font-bold mb-4">{{ listing.title }}</h1>

    <p class="text-gray-800 text-md mb-8 break-words hyphens-auto leading-6">{{ listing.description_header }}</p>

    <AdLink :ads="displayAds.data"></AdLink>

    <TailwindPagination
        :data="displayAds"
        @pagination-change-page="getResults"
    />

    <h2 class="font-bold text-gray-900 text-xl mt-8 mb-2">Features</h2>

    <p class="text-gray-800 text-md mb-8 break-words hyphens-auto leading-6 mb-4" v-html="listing.description_footer"></p>


</template>
<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { TailwindPagination } from 'laravel-vue-pagination';
import Layout from '@/Layouts/GuestLayout.vue';
import axios from 'axios';
import AdLink from '@/Components/AdLink.vue';

const props = defineProps(['listing']);

defineOptions({
    layout: Layout
});


const displayAds = ref({'data':[]});

const getResults = (page = 1) => {
    axios.get(`/api/listing/${props.listing.slug}/?page=${page}`)
    .then((response) => {
       displayAds.value = response.data;
    });
}

getResults();

</script>


<style scoped>
img {position: absolute; min-width: 100%; min-height: 100%; top: 50%; left:50%; transform: translate(-50%, -50%); }
</style>