<template>
    <Head :title="__('Manage Listing')" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-black leading-tight">
                {{__('Listing Manager')}}
            </h1>
        </template>

        <div class="py-9">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="flex items-center gap-3 px-4 py-3 text-xl font-bold bg-zinc-200">
                        <span class="material-icons-outlined">playlist_add</span>
                        {{__('Create Listing')}}
                    </h2>

                    <div class="p-6 bg-white">
                        <!-- msg success -->
                        <div v-if="$page.props.flash.success"
                            class="w-full rounded mb-4 p-6 text-center text-lg bg-emerald-500 text-white font-semibold">
                            {{ $page.props.flash.success }}
                        </div>

                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <BreezeLabel for="title" :value="__('Title')" />

                                <BreezeInput id="title" type="text" class="mt-1 block w-full"
                                    @keyup="form.clearErrors('title')" :class="{ 'border-red-500': form.errors.title, }"
                                    v-model="form.title" />

                                <span class="mt-1 text-xs text-red-500 font-semibold" v-if="form.errors.title">
                                    {{ form.errors.title }}</span>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="description_head" :value="__('Description Header')" />

                                <textarea id="description_head" cols="30" rows="4"
                                    @keyup="form.clearErrors('description_head')"
                                    :class="{ 'border-red-500': form.errors.description_head }"
                                    v-model="form.description_head"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />

                                <span v-if="form.errors.description_head" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.description_head }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="description_foot" :value="__('Description Footer')" />

                                <textarea id="description_foot" cols="30" rows="4"
                                    @keyup="form.clearErrors('description_foot')"
                                    :class="{ 'border-red-500': form.errors.description_foot }" v-model="form.description_foot"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />

                                <span v-if="form.errors.description_foot" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.description_foot }}
                                </span>
                            </div>

                            <div class="w-full flex flex-col sm:flex-row sm:justify-between mb-4">
                                <div class="w-full sm:w-6/12 sm:mr-4 mb-4 sm:mb-0">
                                    <BreezeLabel for="category" :value="__('Category')" />

                                    <select id="category" v-model="form.category"
                                        :class="{ 'border-red-500': form.errors.category }" @change="loadProducts"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">

                                        <option value="" hidden disabled selected>
                                            {{__('Choose Category')}}
                                        </option>

                                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                            {{ cat.name }}
                                        </option>
                                    </select>

                                    <span class="mt-1 text-xs text-red-500 font-semibold" v-if="form.errors.category">
                                        {{ form.errors.category }}
                                    </span>
                                </div>

                                <div class="w-full sm:w-6/12">
                                    <BreezeLabel for="city" :value="__('City')" />

                                    <select id="city" v-model="form.city" :class="{ 'border-red-500': form.errors.city }"
                                        @change="form.clearErrors('city')"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">

                                        <option value="" hidden disabled selected>
                                            {{__('Choose City')}}
                                        </option>

                                        <option v-for="city in cities" :key="city.id" :value="city.id">
                                            {{ city.name }}
                                        </option>
                                    </select>

                                    <span class="mt-1 text-xs text-red-500 font-semibold" v-if="form.errors.city">
                                        {{ form.errors.city }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="product" :value="__('Product')" />

                                <MultiSelect :products=products_filtred
                                    @selectProduct="product => form.product.push(product)" @unSelectProduct="unLinkProduct"
                                    :error="form.errors.product" :reset=reset @reseted="reseted()"></MultiSelect>
                                <span class="mt-1 text-xs text-red-500 font-semibold" v-if="form.errors.product">
                                    {{ form.errors.product }}</span>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="meta_title" :value="__('Meta Title')" />

                                <BreezeInput id="meta_title" type="text" class="mt-1 block w-full" @keyup="generateSlug"
                                    :class="{ 'border-red-500': form.errors.meta_title, }" v-model="form.meta_title" />

                                <span class="mt-1 text-xs text-red-500 font-semibold" v-if="form.errors.meta_title">
                                    {{ form.errors.meta_title }}</span>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="meta_description" :value="__('Meta Description')" />

                                <textarea id="meta_description" cols="30" rows="4"
                                    @keyup="form.clearErrors('meta_description')"
                                    :class="{ 'border-red-500': form.errors.meta_description }"
                                    v-model="form.meta_description"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />

                                <span v-if="form.errors.meta_description" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.meta_description }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="slug" :value="__('Slug')" />

                                <BreezeInput id="slug" type="text" class="mt-1 block w-full bg-zinc-100"
                                    @keyup="form.clearErrors('slug')" disabled v-model="form.slug" />
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="image" :value="__('Picture')" />

                                <div class="w-full bg-zinc-100 rounded overflow-auto" :class="{ 'border border-red-500': form.errors.image }" >
                                    <input id="image" type="file" class="hidden" @change="displayImage($event)" />

                                    <label for="image" class="bg-zinc-300 hover:bg-zinc-400 block px-4 py-2 transition-all ease-in-out text-white font-bold rounded cursor-pointer" >
                                        {{__('Select Picture')}}
                                    </label>

                                    <div class="md:table md:mx-auto">
                                        <div class="flex flex-wrap gap-3 p-3" v-if="form.image">
                                            <div class="relative overflow-hidden h-28 w-28 bg-white rounded">
                                                <img :src="image" class="img" />
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <span v-if="form.errors.image" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.image }}
                                </span>
                                
                            </div>

                            <div class="flex items-center justify-end mt-8">
                                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    {{__('save')}}
                                </BreezeButton>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import BreezeButton from "@/Components/PrimaryButton.vue";
import BreezeInput from "@/Components/TextInput.vue";
import BreezeLabel from "@/Components/InputLabel.vue";
import MultiSelect from '@/Components/MultiSelect.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const categories = ref();
const cities = ref();
const products_filtred = ref();

const page = usePage();

const reset = ref(false);

const image = ref(null);

const form = useForm({
    title: '',
    description_head: '',
    description_foot: '',
    category: '',
    city: '',
    product: [],
    meta_title: '',
    meta_description: '',
    slug: '',
    image: null
});

const submit = () => {
    form.post(route('listing.create.store'), {
        onSuccess: () => {
            form.reset();
            reset.value = true;
            setTimeout(() => { page.props.flash.success = null;}, 2500);
        },
    });
};

const reseted = (value) => {
    reset.value = value;
}

const unLinkProduct = (product) => {
    var index = form.product.indexOf(product);

    if (index !== -1)
        form.product.splice(index, 1);
}

const loadProducts = () => {
    axios
        .get("/api/get-products_filtred_by_category/" + form.category)
        .then((response) => {
            products_filtred.value = response.data;
            reset.value = true;
        });
};

const generateSlug = () => {
    form.clearErrors('meta_title');

    form.slug = form.meta_title.replaceAll(' ', '-').toLowerCase();
}

const displayImage = (event) => {
            form.clearErrors("image");

            const file = event.target.files[0];


            if (!file.type.match("image.*")) return;

            const reader = new FileReader();

            reader.onload = (e) => image.value = e.target.result;

            reader.readAsDataURL(file);

            form.image = file;
};

onMounted(() => {
    axios
        .get("/api/get-categories-all")
        .then((response) => {
            categories.value = response.data;
        });
    axios
        .get("/api/get-cities-all")
        .then((response) => {
            cities.value = response.data;
        });
});

</script>
<style scoped>
.img {
    position: absolute;
    min-height: 100%;
    min-width: 100%;
    top: 50%;
    left: 50%;
    object-fit: cover;
    transform: translate(-50%, -50%);
}
</style>
