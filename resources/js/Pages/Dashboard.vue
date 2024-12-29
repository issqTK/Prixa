<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps(['totalAds','activeAds','inactiveAds']);

</script>

<template>
    <Head :title="__('Dashboard')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard') }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!--  -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 md:p-6 flex flex-col text-slate-50 gap-4 items-center md:bg-cover bg-center bg-sun-set-item border rounded">
                        <span class="text-xl font-bold md:text-2xl">{{ totalAds }}</span> 
                        <span class="text-sm font-semibold">{{ __('Total Ads') }}</span>
                    </div>

                    <div class="p-4 md:p-6 flex flex-col text-slate-50 gap-4 items-center md:bg-cover bg-center bg-sun-set-item border rounded">
                        <span class="text-xl font-bold md:text-2xl">{{ activeAds }}</span> 
                        <span class="text-sm font-semibold">{{ __('Active Ads') }}</span>
                    </div>

                    <div class="p-4 md:p-6 flex flex-col text-slate-50 gap-4 items-center md:bg-cover bg-center bg-sun-set-item border rounded">
                        <span class="text-xl font-bold md:text-2xl">{{ inactiveAds }}</span> 
                        <span class="text-sm font-semibold">{{ __('Inactive Ads') }}</span>
                    </div>

                    <div class="p-4 md:p-6 flex flex-col text-slate-50 gap-4 items-center md:bg-cover bg-center bg-sun-set-item border rounded">
                        <span class="text-xl font-bold md:text-2xl">0</span> 
                        <span class="text-sm font-semibold">{{ __('Total Views') }}</span>
                    </div>
                </div>
            </div>
        </div>
</AuthenticatedLayout>
</template>
