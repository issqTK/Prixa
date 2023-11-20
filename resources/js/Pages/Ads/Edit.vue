<template>
    <Head title="Edit Ads" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-black leading-tight">
                {{ trans.title_header }}
            </h1>
        </template>

        <div class="py-9">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:shadow-xl sm:rounded-lg">
                    <h2 class="flex items-center gap-3 px-4 py-3 text-xl font-bold bg-zinc-200">
                        <span class="material-icons-outlined">published_with_changes</span>
                        {{ trans.edit_ad_nav }}
                    </h2>

                    <div class="p-6 bg-white border-b border-gray-200">
                        <!--success message-->
                        <div
                            v-if="page.props.flash.success"
                            class="w-full rounded mb-4 p-6 text-center text-base bg-emerald-500 text-white font-semibold"
                        >
                            {{ page.props.flash.success }}
                        </div>

                        <!-- Form -->
                        <form @submit.prevent="submitUpdate">

                            <div class="mb-4">
                                <div class="flex gap-4 items-center">
                                    <BreezeLabel for="state" value="State"/>

                                    <div v-if="ad.state == 'Pending'" class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full border-2 border-amber-400 ring-2 ring-amber-300"></span>
                                        <span class="text-xs font-semibold text-amber-400">Pending</span>
                                    </div>
                                    
                                    <div v-if="ad.state == 'Valid'" class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full border-2 border-emerald-500 ring-2 ring-emerald-400"></span>
                                        <span class="text-xs font-semibold text-emerald-500">Valid</span>
                                    </div>

                                    <div v-if="ad.state == 'Rejected'" class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full border-2 border-red-500 ring-2 ring-red-400"></span>
                                        <span class="text-xs font-semibold text-red-500">Rejected</span>
                                    </div>
                                </div>
                                
                                <div v-if="$page.props.auth.user.admin" class="mt-1">
                                    <select 
                                        id="state"
                                        v-model="form.state"
                                        @change="form.clearErrors('state')"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    >
                                        <option value="Pending">Pending</option>
                                        <option value="Valid">Valid</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>

                                </div>
                               
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="title" :value="trans.title_label"/>

                                <BreezeInput
                                    id="title"
                                    type="text"
                                    @keyup="form.clearErrors('title')"
                                    class="mt-1 w-full"
                                    :class="{'border-red-500': form.errors.title}"
                                    v-model="form.title"
                                />

                                <span v-if="form.errors.title" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.title }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="description" :value="trans.description_label" />

                                <textarea
                                    id="description"
                                    cols="30"
                                    rows="3"
                                    @keyup="form.clearErrors('description')"
                                    class="mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    :class="{'border-red-500':form.errors.description}"
                                    v-model="form.description"
                                />

                                <span v-if="form.errors.description" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.description }}
                                </span>
                            </div>

                            <div class="w-full flex flex-col sm:flex-row sm:justify-between mb-4">
                                <div class="w-full sm:w-6/12 sm:mr-2 mb-4 sm:mb-0">
                                    <BreezeLabel for="price" :value="trans.price_label"/>

                                    <BreezeInput
                                        id="price"
                                        type="number"
                                        @keyup="form.clearErrors('price')"
                                        class="mt-1 w-full"
                                        :class="{'border-red-500': form.errors.price}"
                                        v-model="form.price"
                                    />

                                    <span v-if="form.errors.price" class="mt-1 text-xs text-red-500 font-semibold" >
                                        {{ form.errors.price }}
                                    </span>
                                </div>

                                <div class="w-full sm:w-6/12 sm:ml-2">
                                    <BreezeLabel for="out-price" :value="trans.out_price_label"/>

                                    <BreezeInput
                                        id="out-price"
                                        type="number"
                                        @keyup="form.clearErrors('outPrice')"
                                        class="mt-1 w-full line-through"
                                        :class="{'border-red-500':form.errors.outPrice}"
                                        v-model="form.outPrice"
                                    />

                                    <span v-if="form.errors.outPrice" class="mt-1 text-xs text-red-500 font-semibold">
                                        {{ form.errors.outPrice }}
                                    </span>
                                </div>
                            </div>

                            <!-- filter -->
                            <div class="w-full flex flex-col sm:flex-row sm:justify-between mb-4">
                                <div class="w-full sm:w-6/12 sm:mr-4 mb-4 sm:mb-0">
                                    <BreezeLabel for="category" :value="trans.category_label" />

                                    <select
                                        id="category"
                                        @change="loadProducts"
                                        v-model="form.category"
                                        :class="{'border-red-500':form.errors.category}"
                                        class="mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    >
                                        <option :value="null" hidden disabled selected >{{ trans.Choose_Category }} </option>

                                        <option
                                            v-for="cat in categories"
                                            :key="cat.id"
                                            :value="cat.id"
                                        >
                                            {{ cat.name }}
                                        </option>
                                    </select>

                                    <span v-if="form.errors.category" class="mt-1 text-xs text-red-500 font-semibold">
                                        {{ form.errors.category }}
                                    </span>
                                </div>

                                <div class="w-full sm:w-6/12 sm:mr-4 mb-4 sm:mb-0" >
                                    <BreezeLabel for="product" :value="trans.product_label"/>

                                    <select
                                        id="product"
                                        v-model="form.product"
                                        @change="form.clearErrors('product')"
                                        :class="{ 'border-red-500':form.errors.product }"
                                        class="mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    >
                                        <option 
                                            v-if="current_active" 
                                            :value="props.ad.product.id" 
                                            selected
                                        >
                                            {{ ad.product.name }}
                                        </option>

                                        <option
                                            v-for="product in products_filtred"
                                            :key="product.id"
                                            :value="product.id"
                                        >
                                            {{ product.name }}
                                        </option>
                                    </select>

                                    <span v-if="form.errors.product" class="mt-1 text-xs text-red-500 font-semibold" >
                                        {{ form.errors.product }}
                                    </span>
                                </div>

                                <div class="w-full sm:w-6/12">
                                    <BreezeLabel for="city" :value="trans.city_label"/>

                                    <select
                                        id="city"
                                        v-model="form.city"
                                        @change="form.clearErrors('city')"
                                        :class="{'border-red-500': form.errors.city}"
                                        class="mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    >
                                        <option v-for="city in cities" :key="city.id" :value="city.id" >
                                            {{ city.name }}
                                        </option>
                                    </select>

                                    <span v-if="form.errors.city" class="mt-1 text-xs text-red-500 font-semibold">
                                        {{ form.errors.city }}
                                    </span>
                                </div>
                            </div>

                            <!-- Seo -->
                            <div class="mb-4" v-if="page.props.auth.user.admin == true">
                                <BreezeLabel for="meta_title" value="Meta Title" />

                                <BreezeInput
                                    id="meta_title"
                                    type="text"
                                    @keyup="generateSlug"
                                    class="mt-1 w-full"
                                    :class="{'border-red-500':form.errors.meta_title}"
                                    v-model="form.meta_title"
                                />

                                <span v-if="form.errors.title" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.meta_title }}
                                </span>
                            </div>

                            <div class="mb-4" v-if="page.props.auth.user.admin == true" >
                                <BreezeLabel for="meta_description" value="Meta Description" />

                                <textarea
                                    id="meta_description"
                                    cols="30"
                                    rows="3"
                                    @keyup="form.clearErrors('meta_description')"
                                    class="mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    :class="{'border-red-500':form.errors.meta_description}"
                                    v-model="form.meta_description"
                                />

                                <span v-if="form.errors.meta_description" class="mt-1 text-xs text-red-500 font-semibold">
                                    {{ form.errors.meta_description }}
                                </span>
                            </div>

                            <div class="mb-4" v-if="page.props.auth.user.admin == true">
                                <BreezeLabel for="slug" value="Slug" />

                                <BreezeInput
                                    id="slug"
                                    type="text"
                                    class="mt-1 block w-full bg-zinc-100"
                                    disabled
                                    v-model="form.slug"
                                />
                            </div>

                            <!-- links -->
                            <div class="flex items-center gap-4 justify-end mt-8" >
                                <a
                                    :href="route('ad.view', ad.slug)"
                                    target="_blank"
                                    class="text-zinc-950 uppercase font-semibold text-sm border-b border-transparent hover:border-zinc-950"
                                >
                                    Preview Ad
                                </a>

                                <button @click.prevent="deleteAd"
                                    class="text-rose-600 uppercase font-semibold text-sm border-b border-transparent hover:border-rose-600"
                                >
                                    {{ trans.Delete_Ad }}
                                </button>

                                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    {{ trans.Save_Changes }}
                                </BreezeButton>
                            </div>
                        </form>

                         <!-- Images Setting -->
                         <div class="my-4">
                            <BreezeLabel :value="trans.image_label"></BreezeLabel>

                            <div class="flex items-center justify-between my-4">
                                <input @change="createImage($event)" id="images" type="file" class="hidden" multiple />

                                <label for="images" class="block sm:inline py-3 px-4 bg-transparent hover:bg-zinc-950 text-zinc-950 hover:text-zinc-50 border border-zinc-950 text-sm font-semibold rounded cursor-pointer">
                                    {{ trans.select_image_label }}
                                </label>

                                <!--success message-->
                                <div v-if="page.props.flash.successTwo"
                                    class="block sm:inline sm:float-right mt-2 sm:mt-0 rounded px-4 py-2 text-center text-sm bg-emerald-500 text-white font-semibold"
                                >
                                    {{ page.props.flash.successTwo }}
                                </div>

                                <!--Error message-->
                                <div v-if="errorImage"
                                    class="block sm:inline sm:float-right mt-2 sm:mt-0 rounded px-4 py-2 text-center text-sm bg-red-400 text-white font-semibold"
                                >
                                    {{ errorImage }}
                                </div>
                            </div>

                            <div class="flex flex-wrap justify-center gap-3 mt-4 p-3 bg-zinc-100 rounded">
                                <div v-for="(image, index) in imagesList" :key="index" class=" group relative w-28 h-28 bg-white rounded overflow-hidden">
                                    <img :src="image.source.startsWith('http') ? image.source : '/storage/images/ads/' + image.source " class="greatH" />
                                    
                                    <span v-if="image.active"
                                        class="absolute left-0 right-0 bottom-0 h-9 flex items-center justify-center font-bold uppercase text-white " 
                                        style="background: rgba(0, 0, 0, 0.776); font-size:.6em">
                                        active
                                    </span>
                                    
                                    <span v-else @click="makeItActive(image.id)"
                                        class="absolute left-0 right-0 -bottom-9 group-hover:bottom-0 h-9 transition-all flex items-center justify-center font-bold uppercase text-black cursor-pointer" 
                                        style="background: rgba(255, 255, 255, 0.776);font-size:.6em">
                                        Make active
                                    </span>
                                    
                                    <svg v-if="!image.active" 
                                        @click="deleteImage(image.id, index)" 
                                        title="click to delete" 
                                        xmlns="http://www.w3.org/2000/svg" 
                                        class="absolute -top-0 left-0 h-4 w-4 text-white hover:text-red-500 bg-red-500 hover:bg-white cursor-pointer rounded-full" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { Head, router, usePage, useForm, Link } from "@inertiajs/vue3";
import { ref, onMounted, reactive } from "vue";
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreezeButton from "@/Components/PrimaryButton.vue";
import BreezeInput from "@/Components/TextInput.vue";
import BreezeLabel from "@/Components/InputLabel.vue";

const page = usePage();

const trans = ref(page.props.lang.ad);

const props = defineProps(["ad"]);

const cities = ref();

const categories = ref();

const products_filtred = ref();

const current_active = ref(true);

const deleteAd = () => { 
    router.delete(route('ads.delete', props.ad.id), {
        onBefore: () => confirm('Are you sure you want to delete this user?'),
        onSuccess: () => setTimeout(page.props.flash.success = null, 2500)
    });
};

const generateSlug = () => {
    form.clearErrors("meta_title");
    form.slug = form.meta_title.replaceAll(" ", "-").toLowerCase();
};

const imagesList = ref(props.ad.images);

const listFilesName = ref([]);

const errorImage = ref(null);

const form = useForm({
    title: props.ad.title,
    description: props.ad.description,
    meta_title: props.ad.meta_title,
    meta_description: props.ad.meta_description,
    price: props.ad.price,
    outPrice: (props.ad.out_price ??= ""),
    product: props.ad.product.id,
    city: props.ad.city_id,
    category: null,
    slug: props.ad.slug,
    state: props.ad.state
});

const loadProducts = () => {
    axios
    .get("/api/get-products_filtred_by_category/" + form.category)
    .then((response) => {
        products_filtred.value = response.data;
        current_active.value = false;
    });
};

const makeItActive = (image) => {
    router.put(route('make.it.active', image), {'adID' : props.ad.id}, {
        preserveScroll: true,
        onSuccess: () => {
            setTimeout(() => { page.props.flash.successTwo = null }, 2500);
            imagesList.value = props.ad.images
        },
    });
}

const deleteImage = (imageID, index) => {
    router.get(route('ad.delete.image', imageID), {}, {
        preserveState: true,
        preserveScroll: true,
        onBefore: () => confirm('Are you Sure!'),
        onSuccess: () => {
            setTimeout(() => { page.props.flash.successTwo = null }, 2500);
            imagesList.value = props.ad.images;
        },
    });
};

const createImage = (event) => {
    const files = event.target.files;

    const images = [];

    if (files.length + imagesList.value.length > 8) {
        errorImage.value = "only 8 pictures allowed!";

        setTimeout(() => {errorImage.value = null;}, 2500);

        return;
    }

    Array.from(files).forEach((file) => {
        if (!file.type.match("image.*")) {
            errorImage.value = "File uploaded is not an Image!";

            setTimeout(() => {errorImage.value = null;}, 2500);
            
            return;
        } 

        if (listFilesName.length >= 0 && listFilesName.value.includes(file.name)) return;

        listFilesName.value.push(file.name);

        const reader = new FileReader();

        reader.readAsDataURL(file);

        images.push(file);

        
    });

    router.post(route('ad.upload.images', props.ad.id), { files: images }, {
        preserveScroll: true,
        onSuccess: () => {
            if (page.props.flash.data)
                page.props.flash.data.forEach((img) => {
                    imagesList.value.push(img);
                });

            setTimeout(() => { page.props.flash.successTwo = null}, 4000);
        }
    });
};

const submitUpdate = () => {
    form.put(route("ads.update", props.ad.id), {
        onSuccess: () => {
            setTimeout(() => {page.props.flash.success = null}, 2500);
        },
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
.greatH {
    position: absolute;
    min-height: 100%;
    min-width: 100%;
    top: 50%;
    left: 50%;
    object-fit: cover;
    transform: translate(-50%, -50%);
}
</style>
