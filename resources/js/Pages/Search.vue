<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import Layout from "@/Layouts/GuestLayout.vue";
import { TailwindPagination } from "laravel-vue-pagination";
import { ref, onMounted } from "vue";
import axios from "axios";
import AdLink from "@/Components/AdLink.vue";
import btn from "@/Components/Button.vue";

defineProps([]);

defineOptions({ layout: Layout });

const classes =
    "focus:outline-none focus:border-none focus:ring-offset-0 focus:ring-2 focus:ring-cyan-400";

const form = useForm({
    search: null,
    city: null,
    category: null,
});

const cities = ref();
const categories = ref();

const displayAds = ref({ data: [] });

const getResults = (page = 1) => {
    axios
        .get(`/api/search?page=${page}`, {
            params: {
                search: form.search,
                category: form.category,
                city: form.city,
            },
        })
        .then((response) => {
            displayAds.value = response.data;
        })
        .then(() => {
            document
                .getElementById("search")
                .scrollIntoView({ behavior: "smooth" });
        });
};

onMounted(() => {
    axios.get("/api/get-cities-all").then((response) => {
        cities.value = response.data;
    });

    axios.get("/api/get-categories-all").then((response) => {
        categories.value = response.data;
    });
});
</script>
<template>
    <h1 class="font-bold text-2xl mb-4">Search for Phones</h1>

    <form id="search" class="flex gap-4 mb-6">
        <div class="flex flex-col flex-1 gap-2">
            <input
                type="search"
                v-model="form.search"
                placeholder="Use Keywords"
                class="rounded text-sm border-gray-200"
                :class="classes"
            />

            <div class="flex gap-2">
                <select
                    v-model="form.city"
                    class="w-6/12 rounded bg-slate-100 text-sm border-none"
                    :class="classes"
                >
                    <option disabled selected :value="null">All Cities</option>
                    <option
                        v-for="city in cities"
                        :key="city.id"
                        :value="city.id"
                        class="bg-slate-50"
                    >
                        {{ city.name }}
                    </option>
                </select>

                <select
                    v-model="form.category"
                    class="w-6/12 rounded bg-slate-100 text-sm border-none"
                    :class="classes"
                >
                    <option disabled selected :value="null">
                        All Categories
                    </option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                        class="bg-slate-50"
                    >
                        {{ category.name }}
                    </option>
                </select>
            </div>
        </div>

        <btn @click.prevent="getResults" class="px-8"> Search </btn>
    </form>

    <AdLink :ads="displayAds.data"></AdLink>

    <TailwindPagination
        :data="displayAds"
        @pagination-change-page="getResults"
    />
</template>
