<template>
    <Head :title="head" />
    
    <BreezeAuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-black leading-tight">
                {{ header }}
            </h1>
        </template>
    
        <div class="py-9">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="flex items-center gap-3 px-4 py-3 text-xl font-bold bg-zinc-200">
                        <span class="material-icons-outlined">playlist_add</span>
                        {{ trans.h2 }}
                    </h2>

                    <div class="p-6 bg-white">
                        <!-- msg success -->
                        <div v-if="$page.props.flash.success"
                            class="w-full rounded mb-4 p-6 text-center text-base bg-emerald-500 text-white font-semibold">
                            {{ $page.props.flash.success }}
                        </div>

                        <form @submit.prevent="submit">
                            <div v-if="$page.props.auth.user.admin" class="mb-4">
                                <BreezeLabel for="state" :value="trans.state_label"/>
                                
                                <select 
                                    id="state"
                                    v-model="form.state"
                                    @change="form.clearErrors('state')"
                                    class="mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                >
                                    <option value="Pending">{{ trans.pending_option }}</option>
                                    <option value="Valid">{{ trans.valid_option }}</option>
                                    <option value="Rejected">{{ trans.rejected_option }}</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="title" :value="trans.title_label" />

                                <BreezeInput id="title" type="text" class="mt-1 block w-full"
                                    @keyup="form.clearErrors('title')" 
                                    :class="{'border-red-500': form.errors.title}" 
                                    v-model="form.title" />

                                <span v-if="form.errors.title" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.title }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="description" :value="trans.description_label" />

                                <textarea id="description" cols="30" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    @keyup="form.clearErrors('description')" 
                                    :class="{'border-red-500':form.errors.description}" 
                                    v-model="form.description" />

                                <span v-if="form.errors.description" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.description }}
                                </span>
                            </div>

                            <div class="w-full flex flex-col sm:flex-row sm:justify-between mb-4">
                                <div class="w-full sm:w-6/12 sm:mr-2 mb-4 sm:mb-0">
                                    <BreezeLabel for="price" :value="trans.price_label" />

                                    <BreezeInput id="price" type="number" 
                                        class="mt-1 block w-full"
                                        :class="{'border-red-500': form.errors.price}" 
                                        @keyup="form.clearErrors('price')" 
                                        v-model="form.price" />

                                    <span v-if="form.errors.price" class="mt-1 text-xs text-red-500 font-semibold">
                                        {{ form.errors.price }}
                                    </span>
                                </div>

                                <div class="w-full sm:w-6/12 sm:ml-2">
                                    <BreezeLabel for="out-price" :value="trans.out_price_label" />

                                    <BreezeInput id="out-price" type="number" 
                                        class="mt-1 block w-full line-through"
                                        :class="{'border-red-500':form.errors.outPrice}"
                                        @keyup="form.clearErrors('outPrice')"  
                                        v-model="form.outPrice" />

                                    <span v-if="form.errors.outPrice" class="mt-1 text-xs text-red-500 font-semibold">
                                        {{ form.errors.outPrice }}
                                    </span>
                                </div>
                            </div>

                            <div class="w-full flex flex-col sm:flex-row sm:justify-between mb-4">
                                <div class="w-full sm:w-6/12 sm:mr-4 mb-4 sm:mb-0">
                                    <BreezeLabel for="category" :value="trans.category_label" />

                                    <select id="category" 
                                        v-model="form.category" 
                                        @change="loadProducts"
                                        :class="{'border-red-500': form.errors.category}" 
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">

                                        <option value="" hidden disabled selected>{{ trans.choose_category_option }} </option>
                                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                                    </select>

                                    <span v-if="form.errors.category" class="mt-1 text-xs text-red-500 font-semibold">
                                        {{ form.errors.category }}
                                    </span>
                                </div>

                                <div class="w-full sm:w-6/12 sm:mr-4 mb-4 sm:mb-0">
                                    <BreezeLabel for="product" :value="trans.product_label" />

                                    <select id="product" 
                                        v-model="form.product" 
                                        @change="form.clearErrors('product')"
                                        :class="{'border-red-500':form.errors.product}" 
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">

                                        <option value="" hidden disabled selected>{{ trans.choose_product_option }}</option>
                                        <option v-for="product in products_filtred" :key="product.id" :value="product.id">
                                            {{ product.name }}
                                        </option>
                                    </select>

                                    <span v-if="form.errors.product" class="mt-1 text-xs text-red-500 font-semibold">
                                        {{ form.errors.product }}
                                    </span>
                                </div>

                                <div class="w-full sm:w-6/12">
                                    <BreezeLabel for="city" :value="trans.city_label" />

                                    <select id="city" 
                                        v-model="form.city" 
                                        @change="form.clearErrors('city')"
                                        :class="{'border-red-500': form.errors.city}" 
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">

                                        <option value="" hidden disabled selected>{{ trans.choose_city_option }}</option>
                                        <option v-for="city in cities" :key="city.id" :value="city.id">
                                            {{ city.name }}
                                        </option>
                                    </select>

                                    <span v-if="form.errors.city" class="mt-1 text-xs text-red-500 font-semibold">
                                        {{ form.errors.city }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4" v-if="$page.props.auth.user.admin == true">
                                <BreezeLabel for="meta_title" :value="trans.meta_title_label" />

                                <BreezeInput 
                                    id="meta_title" 
                                    type="text" 
                                    class="mt-1 block w-full"
                                    @keyup="generateSlug" 
                                    :class="{ 'border-red-500': form.errors.meta_title }" 
                                    v-model="form.meta_title" />

                                <span v-if="form.errors.meta_title" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.meta_title }}
                                </span>
                            </div>

                            <div class="mb-4" v-if="$page.props.auth.user.admin == true">
                                <BreezeLabel for="meta_description" :value="trans.meta_description_label" />

                                <textarea id="meta_description" cols="30" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    @keyup="form.clearErrors('meta_description')" 
                                    :class="{ 'border-red-500' : form.errors.meta_description }" 
                                    v-model="form.meta_description" />

                                <span v-if="form.errors.meta_description" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.meta_description }}
                                </span>
                            </div>
                            
                            <div class="mb-4" v-if="$page.props.auth.user.admin">
                                <BreezeLabel for="slug" :value="trans.slug_label" />

                                <BreezeInput
                                    id="slug"
                                    type="text"
                                    class="mt-1 block w-full bg-zinc-100"
                                    disabled
                                    v-model="form.slug"
                                />                            
                            </div>

                            <div class="w-full mb-4">
                                <BreezeLabel :value="trans.image_label" for="images" />

                                <div class="w-full bg-zinc-100 rounded overflow-auto" 
                                    :class="{ 'border border-red-500': form.errors.images }" >
                                    
                                    <input @change="displayImage($event)" id="images" type="file" class="hidden" multiple />

                                    <label for="images" class="bg-zinc-300 hover:bg-zinc-400 block px-4 py-2 transition-all ease-in-out text-white font-bold rounded cursor-pointer" >
                                        {{ trans.select_image_label }}
                                    </label>

                                    <div class="md:table md:mx-auto">
                                        <div v-if="form.images" class="flex flex-wrap gap-3 p-3">
                                            <div v-for="(image, index) in images" :key="index" 
                                                class="relative overflow-hidden h-28 w-28 bg-white rounded">
                                                <img :src="image" class="img" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <span v-if="form.errors.images" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.images }} 
                                </span>
                            </div>

                            <div class="flex items-center justify-end mt-8">
                                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    {{ trans.save_btn }}
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
import { Head, useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreezeButton from "@/Components/PrimaryButton.vue";
import BreezeInput from "@/Components/TextInput.vue";
import BreezeLabel from "@/Components/InputLabel.vue";

const props = defineProps(['head', 'header', 'trans', 'pictures_allowed']);

const cities = ref();
const categories = ref();
const products_filtred = ref();

const images = ref([]);
const listFilesName = ref([]);

const form = useForm({
    title: "",
    description: "",
    meta_title: "",
    meta_description: "",
    price: "",
    outPrice: "",
    category: "",
    product: "",
    city: "",
    slug: "",
    state: 'Pending',
    images: [],
});

const submit = () => {
    form.post(route("ads.store"), {
        preserveScroll: true,
        onSuccess: () => {
            window.scrollTo(0, 0);
            form.reset();
            images.value.splice(0);
            products_filtred.value.splice(0);
        },
    });
};

const generateSlug = () => {
    form.clearErrors("meta_title");
    form.slug = form.meta_title.replaceAll(" ", "-").toLowerCase();
};

const loadProducts = () => {
    axios
    .get("/api/get-products_filtred_by_category/" + form.category)
    .then((response) => {
        products_filtred.value = response.data;
    });
};

const displayImage = (event) => {
    form.clearErrors("images");

    const files = event.target.files;

    if (files.length > 8) {
        form.errors.images = props.pictures_allowed;

        setTimeout(() => { form.errors.images = null }, 2500);

        return
    }

    Array.from(files).forEach((file) => {
        if (!file.type.match("image.*")) return;

        if (images.value.length >= 8) {
            form.errors.images = props.pictures_allowed;

            setTimeout(() => { form.errors.images = null }, 2500);
            
            return
        }
        
        if (listFilesName.value.includes(file.name)) return;

        listFilesName.value.push(file.name);

        const reader = new FileReader();

        reader.onload = (e) => images.value.push(e.target.result);

        reader.readAsDataURL(file);

        form.images.push(file);
    });
};

onMounted(() => {
    axios
    .get("/api/get-cities-all")
    .then((response) => {
        cities.value = response.data;
    });

    axios
    .get("/api/get-categories-all")
    .then((response) => {
       categories.value = response.data;
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