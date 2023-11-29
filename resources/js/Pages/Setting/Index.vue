<template>
    <Head :title="__('Settings')" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Settings') }}</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl flex flex-col gap-24 mx-auto sm:px-6 lg:px-8">

                <LogoSetting :logos="logos"></LogoSetting>
                
                <CategorySetting></CategorySetting>

                <CitySetting></CitySetting>

            </div>
        </div>        
    </AuthenticatedLayout>
</template>

<script>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CategorySetting from './Category/List.vue';
import CitySetting from './City/List.vue';
import LogoSetting from './LogoSetting.vue';

export default {
    props: ['logos'],
    components: {
        Head, 
        AuthenticatedLayout, 
        LogoSetting,
        CategorySetting, 
        CitySetting
    }

}

</script>