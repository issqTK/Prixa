<template>
    <Head :title="ad.meta_title" />

    <div class="flex flex-col gap-8 ">

        <h1 class="text-2xl capitalize font-bold"> {{ ad.title }} </h1>

        <div class="flex flex-row items-start gap-6 p-6 rounded-md bg-slate-50">

            <div class="flex flex-col items-center py-4 gap-3 w-3/12 bg-white rounded">
                <a v-for="img in this.ad.images" :key="img.id" @click="displayImage(img.source)"
                    class="rotate relative overflow-hidden h-20 w-20 cursor-pointer rounded bg-slate-100"
                    title="Click To Display">

                    <img v-if="/^http/.test(img.source)" :src="img.source" draggable="false" class="image-center">
                    <img v-else :src="'/storage/images/ads/' + img.source" draggable="false" class="image-center">
                </a>
            </div>

            <div class="flex-1 bg-white rounded overflow-hidden">
                <img v-if="/^http/.test(image_active)" :src="image_active" draggable="false" class="w-full">
                <img v-else :src="'/storage/images/ads/' + image_active" draggable="false" class="w-full" />
            </div>
        </div>

        <div class="flex justify-between text-gray-900">
            <div class="flex gap-5 text-xs font-bold">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                        style="fill: rgb(0, 0, 0);">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                            clip-rule="evenodd" />
                    </svg>
                    <span> {{ ad.product.name }}</span>
                </div>

                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="MapPinFillTitleID"
                        style="fill: rgb(0, 0, 0); stroke: rgb(155, 155, 155); stroke-width: 0;">
                        <path
                            d="M18.364 17.364L12 23.728l-6.364-6.364a9 9 0 1112.728 0zM12 15a4 4 0 100-8 4 4 0 000 8zm0-2a2 2 0 110-4 2 2 0 010 4z">
                        </path>
                    </svg>
                    <span class="">{{ ad.city.name }}</span>
                </div>

                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="TimeFillTitleID"
                        style="fill: rgb(0, 0, 0); stroke: rgb(155, 155, 155); stroke-width: 0;">
                        <path
                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm1-10V7h-2v7h6v-2h-4z">
                        </path>
                    </svg>
                    <span>{{ moment(ad.created_at).format('MM/DD/YYYY') }}</span>
                </div>
            </div>

            <span v-if='ad.price !== null' class="text-2xl text-sky-500 font-bold">{{ ad.price }} $</span>
            <span v-else class="text-xl text-sky-500 font-bold">Price not specified</span>
        </div>


        <div class="p-4 text-justify leading-9 rounded bg-slate-50 text-gray-900">
            <p> {{ ad.description }} </p>
        </div>

        <div class="mt-4 flex gap-3">
            <a :href="'tel:' + ad.user.phone"
                class="font-bold capitalize hover:bg-sky-500 bg-sky-600 text-white p-3 rounded">
                Call Seller
            </a>

            <a :href="'tel:' + ad.user.whatsapp"
                v-if="ad.user.whatsapp"
                class="font-bold capitalize hover:bg-emerald-400 bg-emerald-500 text-white p-3 rounded">
                Whatsapp
            </a>

            <a :href="ad.user.store_address"
                v-if="ad.user.store_address"
                target="_blank"
                class="font-bold capitalize bg-stone-300 text-white p-3 rounded">
                Shop
            </a>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';
import Layout from '@/Layouts/GuestLayout.vue';
import moment from 'moment'

export default {
    props: ['ad'],
    layout: Layout,
    components: {
        Head,
    },
    data() {
        return {
            image_active: [],
            moment: moment
        }
    },
    methods: {
        displayImage(src) {
            this.image_active = src
        }
    },
    mounted() {
        this.ad.images.forEach((image) => {
            if (image.active == true)
                this.image_active = image.source;
        });
    }
}
</script>

<style scoped>
.rotate:hover {
    transform: rotate(360deg);
    transition: all .4s ease;
}

.image-center {
    position: absolute;
    min-width: 100%;
    min-height: 100%;
    top: 50%;
    left: 50%;
    object-fit:cover;
    transform: translate(-50%, -50%);
}
</style>