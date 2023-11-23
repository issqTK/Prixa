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
                    <h2
                        class="flex items-center gap-3 px-4 py-3 text-xl font-bold bg-zinc-200"
                    >
                        <span class="material-icons-outlined"
                            >published_with_changes</span
                        >
                        {{__('Edit Listing')}}
                    </h2>

                    <div class="p-6 bg-white">
                        <!-- msg success -->
                        <div
                            v-if="$page.props.flash.success"
                            class="w-full rounded mb-4 p-6 text-center text-lg bg-emerald-500 text-white font-semibold"
                        >
                            {{ $page.props.flash.success }}
                        </div>

                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <BreezeLabel for="title" :value="__('Title')" />

                                <BreezeInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    @keyup="form.clearErrors('title')"
                                    :class="{
                                        'border-red-500': form.errors.title,
                                    }"
                                    v-model="form.title"
                                />

                                <span
                                    class="mt-1 text-xs text-red-500 font-semibold"
                                    v-if="form.errors.title"
                                >
                                    {{ form.errors.title }}</span
                                >
                            </div>

                            <div class="mb-4">
                                <BreezeLabel
                                    for="description_head"
                                    :value="__('Description Header')"
                                />
                                <textarea
                                    id="description_head"
                                    cols="30"
                                    rows="4"
                                    @keyup="
                                        form.clearErrors('description_head')
                                    "
                                    :class="{
                                        'border-red-500':
                                            form.errors.description_head,
                                    }"
                                    v-model="form.description_head"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                />

                                <span
                                    v-if="form.errors.description_head"
                                    class="mt-1 text-xs text-red-500 font-semibold"
                                >
                                    {{ form.errors.description_head }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel
                                    for="description_foot"
                                    :value="__('Description Footer')"
                                />
                                <textarea
                                    id="description_foot"
                                    cols="30"
                                    rows="4"
                                    @keyup="
                                        form.clearErrors('description_foot')
                                    "
                                    :class="{
                                        'border-red-500':
                                            form.errors.description_foot,
                                    }"
                                    v-model="form.description_foot"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                />

                                <span
                                    v-if="form.errors.description_foot"
                                    class="mt-1 text-xs text-red-500 font-semibold"
                                >
                                    {{ form.errors.description_foot }}
                                </span>
                            </div>

                            <div
                                class="w-full flex flex-col sm:flex-row sm:justify-between mb-4"
                            >
                                <div
                                    class="w-full sm:w-6/12 sm:mr-4 mb-4 sm:mb-0"
                                >
                                    <BreezeLabel
                                        for="category"
                                        :value="__('Category')"
                                    />

                                    <select
                                        id="category"
                                        v-model="form.category"
                                        :class="{
                                            'border-red-500':
                                                form.errors.category,
                                        }"
                                        @change="loadProducts"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    >
                                        <option
                                            value=""
                                            hidden
                                            disabled
                                            selected
                                        >
                                            {{__('Choose Category')}}
                                        </option>

                                        <option
                                            v-for="cat in categories"
                                            :key="cat.id"
                                            :value="cat.id"
                                        >
                                            {{ cat.name }}
                                        </option>
                                    </select>

                                    <span
                                        class="mt-1 text-xs text-red-500 font-semibold"
                                        v-if="form.errors.category"
                                    >
                                        {{ form.errors.category }}
                                    </span>
                                </div>

                                <div class="w-full sm:w-6/12">
                                    <BreezeLabel for="city" :value="__('City')" />

                                    <select
                                        id="city"
                                        v-model="form.city"
                                        :class="{
                                            'border-red-500': form.errors.city,
                                        }"
                                        @change="form.clearErrors('city')"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    >
                                        <option
                                            value=""
                                            hidden
                                            disabled
                                            selected
                                        >
                                            {{__('Choose City')}}
                                        </option>

                                        <option
                                            v-for="city in cities"
                                            :key="city.id"
                                            :value="city.id"
                                        >
                                            {{ city.name }}
                                        </option>
                                    </select>

                                    <span
                                        class="mt-1 text-xs text-red-500 font-semibold"
                                        v-if="form.errors.city"
                                    >
                                        {{ form.errors.city }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="product" :value="__('Product')" />

                                <MultiSelect
                                    :products="products_filtred"
                                    :selectedProducts="props.selectedProducts"
                                    @selectProduct="
                                        (product) => form.product.push(product)
                                    "
                                    @unSelectProduct="unLinkProduct"
                                    :error="form.errors.product"
                                    :reset="reset"
                                    @reseted="reseted()"
                                ></MultiSelect>

                                <span
                                    class="mt-1 text-xs text-red-500 font-semibold"
                                    v-if="form.errors.product"
                                >
                                    {{ form.errors.product }}</span
                                >
                            </div>

                            <div class="mb-4">
                                <BreezeLabel
                                    for="meta_title"
                                    :value="__('Meta Title')"
                                />

                                <BreezeInput
                                    id="meta_title"
                                    type="text"
                                    class="mt-1 w-full bg-zinc-100"
                                    disabled
                                    @keyup="generateSlug"
                                    :class="{
                                        'border-red-500':
                                            form.errors.meta_title,
                                    }"
                                    v-model="form.meta_title"
                                />

                                <span
                                    class="mt-1 text-xs text-red-500 font-semibold"
                                    v-if="form.errors.meta_title"
                                >
                                    {{ form.errors.meta_title }}</span
                                >
                            </div>

                            <div class="mb-4">
                                <BreezeLabel
                                    for="meta_description"
                                    :value="__('Meta Description')"
                                />

                                <textarea
                                    id="meta_description"
                                    cols="30"
                                    rows="4"
                                    @keyup="
                                        form.clearErrors('meta_description')
                                    "
                                    :class="{
                                        'border-red-500':
                                            form.errors.meta_description,
                                    }"
                                    v-model="form.meta_description"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                />

                                <span
                                    v-if="form.errors.meta_description"
                                    class="mt-1 text-xs text-red-500 font-semibold"
                                >
                                    {{ form.errors.meta_description }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <BreezeLabel for="slug" :value="__('Slug')" />

                                <BreezeInput
                                    id="slug"
                                    type="text"
                                    class="mt-1 block w-full bg-zinc-100"
                                    disabled
                                    v-model="form.slug"
                                />
                            </div>

                            <div class="flex items-center justify-end gap-4 mt-8">
                                <button @click.prevent="deleteListing"
                                    class="text-rose-600 uppercase font-semibold text-sm border-b border-transparent hover:border-rose-600"
                                >
                                    {{ __('Delete') }}
                                </button>

                                <BreezeButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    {{__('save')}}
                                </BreezeButton>
                            </div>
                        </form>

                        <!-- Change Image -->
                        <div class="my-4">
                            <BreezeLabel :value="__('Picture')"></BreezeLabel>

                            <div class="flex items-center justify-between my-4">
                                <input
                                    id="image"
                                    type="file"
                                    class="hidden"
                                    @change="displayImage($event)"
                                />

                                <label
                                    for="image"
                                    class="block sm:inline py-3 px-4 bg-transparent hover:bg-zinc-950 text-zinc-950 hover:text-zinc-50 border border-zinc-950 text-sm font-semibold rounded cursor-pointer"
                                >
                                    {{__('Select Picture')}}
                                </label>

                                <!--success message-->
                                <div
                                    v-if="$page.props.flash.successTwo"
                                    class="block sm:inline sm:float-right mt-2 sm:mt-0 rounded px-4 py-2 text-center text-sm bg-emerald-500 text-white font-semibold"
                                >
                                    {{ $page.props.flash.successTwo }}
                                </div>
                            </div>

                            <div
                                class="inline-block mt-4 p-3 bg-zinc-100 rounded"
                            >
                                <div
                                    class="relative w-28 h-28 bg-white rounded overflow-hidden"
                                >
                                    <img :src="image" class="img" />
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
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreezeButton from "@/Components/PrimaryButton.vue";
import BreezeInput from "@/Components/TextInput.vue";
import BreezeLabel from "@/Components/InputLabel.vue";
import MultiSelect from "@/Components/MultiSelect.vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";

const props = defineProps(["listing", "selectedProducts", "areYouSure"]);

const page = usePage();

const categories = ref();
const cities = ref();
const products_filtred = ref();

const reset = ref(false);

const image = ref("/storage/images/listings/" + props.listing.avatar);

const reseted = (value) => {
    reset.value = value;
};

const form = useForm({
    title: props.listing.title,
    description_head: props.listing.description_header,
    description_foot: props.listing.description_footer,
    city: props.listing.city_id,
    category: props.selectedProducts[0].category_id,
    product: props.listing.product_ids,
    meta_title: props.listing.meta_title,
    meta_description: props.listing.meta_description,
    slug: props.listing.slug,
});

const submit = () => {
    form.put(route("listing.edit.update", props.listing.id), {
        onSuccess: () => {
            setTimeout(() => {
                page.props.flash.success = null;
            }, 2500);
        },
    });
};

const deleteListing = () => {
    router.delete(route('listing.delete', props.listing.id), {
        onBefore: () => confirm(props.areYouSure),
        onSuccess: () => setTimeout(() => { page.props.flash.success = null;}, 2500),
    });
}

const unLinkProduct = (product) => {
    var index = form.product.indexOf(product);

    if (index !== -1) form.product.splice(index, 1);
};

const loadProducts = () => {
    axios
        .get("/api/get-products_filtred_by_category/" + form.category)
        .then((response) => {
            products_filtred.value = response.data;
            reset.value = true;
        });
};

const generateSlug = () => {
    form.clearErrors("meta_title");

    form.slug = form.meta_title.replaceAll(" ", "-").toLowerCase();
};

const displayImage = (event) => {
    const file = event.target.files[0];

    if (!file.type.match("image.*")) return;

    const reader = new FileReader();

    reader.onload = (e) => (image.value = e.target.result);

    reader.readAsDataURL(file);

    router.post(
        "/api/save-listing-image/" + props.listing.id,
        { myFile: file },
        {
            preserveScroll: true,
            onSuccess: () => {
                setTimeout(() => {
                    page.props.flash.successTwo = null;
                }, 4000);
            },
        }
    );
};

onMounted(() => {
    axios.get("/api/get-categories-all").then((response) => {
        categories.value = response.data;
    });
    axios.get("/api/get-cities-all").then((response) => {
        cities.value = response.data;
    });

    axios
        .get("/api/get-products_filtred_by_category/" + form.category)
        .then((response) => {
            products_filtred.value = response.data;
        });
});
</script>
