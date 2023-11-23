<template>
    <Head :title="__('Profile')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{__('Profile')}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8">
                    <label 
                        v-if="$page.props.auth.user.profile_picture"
                        for="file" 
                        class="relative group flex justify-center items-center cursor-pointer h-64 w-64 md:max-w-full"
                        >
                        <img 
                            :src="'/images/profile/' + $page.props.auth.user.profile_picture" 
                            alt="profile picture"
                            class="absolute w-full top-2/4 -translate-y-1/2 right-0 z-0 group-hover:opacity-20 transition-all rounded-full"
                            >
                        <span class="bg-white z-10 text-lg font-semibold rounded p-2 invisible group-hover:visible transition-all">
                            {{__('Choose Image')}}
                        </span>
                    </label>

                    <label 
                        v-else
                        for="file"
                        class="relative group flex justify-center items-center cursor-pointer h-64 w-64 md:max-w-full"
                        >
                        <img 
                            src='/images/profile/profil_default.png'
                            class="absolute w-full top-0 right-0 z-0 group-hover:opacity-20 transition-all rounded-full"
                            alt="profile picture"
                            >
                        <span class="bg-white z-10 text-lg font-semibold rounded p-2 invisible group-hover:visible transition-all">
                            {{__('Choose Image')}}</span>
                    </label>

                    <Cropper @is-emit="createImage($event)" />

                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

import Cropper from '@/Components/Cropper.vue';

import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const createImage = (event) => {

    let formData = new FormData();

    formData.append('file', event);

    router.post(route('profile.add.picture'), formData, {
        preserveState: true,
    });
}
</script>