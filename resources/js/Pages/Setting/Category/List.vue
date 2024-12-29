<template>
    <div class="relative rounded sm:rounded-lg shadow sm:shadow-xl">
        <h3 class="absolute uppercase text-lg font-bold left-0 -top-10 text-zinc-700">{{ __('Category Settings') }}</h3>

        <div v-if="$page.props.flash.success"
            class="text-white font-semibold text-sm bg-zinc-600 p-2 rounded absolute right-0 bottom-2/4 translate-y-2/4 z-10">
            {{ $page.props.flash.success }}
        </div>

        <div v-if="$page.props.flash.error"
            class="text-white font-semibold text-sm bg-rose-600 p-2 rounded absolute right-0 bottom-2/4 translate-y-2/4 z-10">
            {{ $page.props.flash.error }}
        </div>

        <button @click.prevent="ShowingModal = true"
            class="absolute -top-12 right-2 inline-flex items-center justify-center gap-2 py-2 px-4 text-xs font-bold tracking-wide uppercase hover:bg-zinc-950 bg-transparent text-zinc-950 hover:text-zinc-50 transition-all easy-in-out rounded border border-zinc-950">
            <span class="material-icons-outlined min-w-min">playlist_add</span>
            {{ __('New Category') }}
        </button>

        <!-- header -->
        <div class="grid grid-cols-5 flex items-center text-base font-bold rounded-t-md divide-x divide-white text-zinc-900 bg-zinc-200"
            id="category-header">

            <span class="col-span-2"> {{ __('List Categories') }} </span>

            <span>{{ __('Products') }}</span>

            <span>{{ __('Edit') }}</span>

            <span>{{ __('Delete') }}</span>

        </div>

        <!-- content -->
        <div v-if="categories.length > 0" v-for="(category, index) in categories" :key="category.id"
            class="grid grid-cols-5 items-center px-4 py-2 hover:bg-zinc-100 ">

            <span class="col-span-2 text-center">{{ category.name }}</span>

            <span class="text-center">{{ category.products_count }}</span>

            <button @click.prevent="ShowModalEdit(category)" class="text-sm font-semibold text-zinc-900">
                {{ __('Edit') }}</button>

            <button @click.prevent="deleteCategory(category.id, index)" class="text-sm font-semibold text-rose-500">
                {{ __('Delete') }}</button>

        </div>

        <div v-else class="p-2">{{ __('There is no Category yet!') }}</div>
    </div>

    <createCategory 
    :ShowingModal="ShowingModal" 
    @ClosingModal="(value) => this.ShowingModal = value"
    @newCategory="(value) => this.categories.push(value)"
    ></createCategory>

    <EditCategory 
    :ShowingModalEdit="ShowingModalEdit" 
    :currentCategory="currentCategory" 
    :products="products"
    @ClosingModal="(value) => this.ShowingModalEdit = value"
    ></EditCategory>
</template>

<script>
import { router } from '@inertiajs/vue3';
import createCategory from './CreateCategory.vue';
import EditCategory from './EditCategory.vue';

export default {
    components: { createCategory, EditCategory },
    data() {
        return {
            categories: [],
            products: [],
            currentCategory: null,

            ShowingModal: false,
            ShowingModalEdit: false,
        }
    },
    methods: {
        ShowModalEdit(category) {
            axios
                .get("/api/get-products_filtred_by_category/" + category.id)
                .then((response) => this.products = response.data);

            this.currentCategory = category
            this.ShowingModalEdit = true;
        },
        deleteCategory(category, index) {
            router.delete(route('category.delete', category), {
                preserveState: true,
                preserveScroll: true,
                onBefore: () => confirm(this.__('Are you sure you want to delete this category?')),
                onSuccess: () => {
                    if (!this.$page.props.flash.error) {
                        this.categories.splice(index, 1);
                        setTimeout(() => { this.$page.props.flash.success = null; }, 2500);
                    } else {
                        setTimeout(() => { this.$page.props.flash.error = null; }, 2500);
                    }
                }
            });
        },
    },
    mounted() {
        axios.get("/api/get-categories-all").then((response) => {
            this.categories = response.data;
        });
    }
}
</script>

<style scoped>
#category-header>span {
    text-align: center;
    padding: 10px 0;
}
</style>