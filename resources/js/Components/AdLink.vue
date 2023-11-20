<template>
    <Link
        v-for="ad in ads"
        :key="ad.id"
        :href="route('ad.view', ad.slug)"
        class="scale-100 p-4 flex gap-4 shadow hover:shadow-lg mb-6 motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 rounded-md"
    >
        <div class="relative w-32 h-32 overflow-hidden rounded">
            <img
                v-if="/^http/.test(ad.images[0].source)"
                :src="ad.images[0].source"
                class="greatH"
            />
            <img v-else :src="'/storage/images/ads/' + ad.images[0].source" class="greatH"/>
        </div>

        <div class="flex flex-col gap-3 flex-1">
            <h2 class="text-lg font-bold text-gray-900">{{ ad.title }}</h2>

            <div class="flex justify-between text-gray-700">
                <div class="flex items-center font-semibold text-sm">
                    <svg
                        class="w-3 h-3 mr-1"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="MapPinFillTitleID"
                        style="
                            fill: rgb(0, 0, 0);
                            stroke: rgb(155, 155, 155);
                            stroke-width: 0;
                        "
                    >
                        <path
                            d="M18.364 17.364L12 23.728l-6.364-6.364a9 9 0 1112.728 0zM12 15a4 4 0 100-8 4 4 0 000 8zm0-2a2 2 0 110-4 2 2 0 010 4z"
                        ></path>
                    </svg>
                    {{ ad.city.name }}
                </div>

                <div class="flex items-center font-semibold text-sm">
                    <svg
                        class="w-3 h-3 mr-1"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="TimeFillTitleID"
                        style="
                            fill: rgb(0, 0, 0);
                            stroke: rgb(155, 155, 155);
                            stroke-width: 0;
                        "
                    >
                        <path
                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm1-10V7h-2v7h6v-2h-4z"
                        ></path>
                    </svg>
                    {{ moment(ad.created_at).format("MM/DD/YYYY") }}
                </div>

                <div class="flex gap-2 items-center">
                    <span
                        v-if="ad.out_price != null"
                        class="text-sm text-sky-300 line-through"
                        >{{ ad.out_price }} $</span
                    >
                    <span class="text-xl font-bold text-sky-500"
                        >{{ ad.price }} $</span
                    >
                </div>
            </div>

            <p class="text-gray-700 text-sm leading-6 text-justify break-words">
                {{ ad.description }}
            </p>
        </div>
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import moment from "moment";

defineProps(["ads"]);
</script>
<style scoped>
.greatH {
    position:absolute;
    min-height: 100%;
    min-width: 100%;
    top: 50%;
    left: 50%;
    object-fit: cover;
    transform: translate(-50%, -50%);
}
</style>