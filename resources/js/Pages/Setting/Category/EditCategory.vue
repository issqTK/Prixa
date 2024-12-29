<template>
    <modal :show="ShowingModalEdit" @close="closeModal">
        <div class="p-4" v-if="currentCategory !== null">
            <div v-if="$page.props.flash.successTwo"
                class="bg-zinc-600 text-white rounded text-sm opacity-80 w-8/12 text-center py-2 font-semibold absolute top-0 right-2/4 p-2 translate-x-2/4">
                {{ $page.props.flash.successTwo }} </div>

            <div v-if="$page.props.flash.error"
                class="bg-rose-600 text-white rounded text-sm opacity-80 w-8/12 text-center py-2 font-semibold absolute top-0 right-2/4 p-2 translate-x-2/4">
                {{ $page.props.flash.error }} </div>

            <!-- Category -->
            <div class="mb-4">
                <InputLabel for="category" class="mb-1 text-zinc-900">{{ __('Category') }}</InputLabel>

                <div class="flex gap-4 mt-1">
                    <TextInput v-model="currentCategory.name" @keyup="categoryError = null" id="category"
                        class="flex-1 text-sm"></TextInput>

                    <BreezeButton @click.prevent="EditCategory">{{ __('save') }}</BreezeButton>
                </div>

                <div v-if="categoryError"
                    class="text-sm font-semibold opacity-80 text-white bg-rose-500 p-2 rounded absolute top-0 right-2/4 translate-x-2/4">
                    {{ categoryError }}
                </div>
            </div>

            <!-- Products -->
            <InputLabel for="newProduct" class="mb-1">{{ __('Products') }}</InputLabel>

            <!-- list products -->
            <div :class="{ 'mb-4': products.length > 0 }">
                <div v-for="(product, index) in products" :key="product.id"
                    class="flex gap-4 items-center  px-4 py-2 hover:bg-zinc-100">
                    <button @click.prevent="deleteProduct(product.id, index)" class="text-sm font-semibold text-rose-500">
                        {{ __('Delete') }}
                    </button>

                    <div class="w-10 h-10 overflow-hidden relative rounded">
                        <img :src="'/images/phones/' + product.avatar"
                            class="w-full absolute left-0 top-2/4 -translate-y-2/4">
                    </div>

                    {{ product.name }}
                </div>
            </div>

            <div class="flex items-center gap-4">

                <TextInput class="flex-1 text-sm" @keyup="productError = null" v-model="newProduct.name"
                    :placeholder="__('New Product')" id="newProduct"></TextInput>

                <input type="file" id="avatar" class="hidden" @change="uploadFile($event)">

                <label for="avatar" v-show="avatar == null"
                    class="font-medium text-sm text-gray-700 cursor-pointer">{{ __('Select Image') }}</label>

                <div v-show="avatar !== null" class="relative w-10 h-10 overflow-hidden rounded">
                    <img :src="avatar" class="w-full absolute left-0 top-2/4 -translate-y-2/4">
                </div>

                <BreezeButton @click.prevent="addProduct">{{ __('save') }}</BreezeButton>
            </div>

            <div v-if="productError"
                class="text-sm font-semibold text-white bg-rose-500 opacity-80 p-2 rounded absolute bottom-0 right-2/4 translate-x-2/4">
                {{ productError }}
            </div>

        </div>
    </modal>
</template>

<script>
import { router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import BreezeButton from "@/Components/PrimaryButton.vue";

export default {
    props: ['ShowingModalEdit', 'currentCategory', 'products'],
    emits: ['ClosingModal'],
    components: { Modal, InputLabel, TextInput, BreezeButton },
    data() {
        return {
            avatar: null,
            categoryError: null,
            productError: null,
            newProduct: useForm({
                name: '',
                avatar: null,
            }),
        }
    },
    methods: {

        addProduct() {
            if (!/^[a-zA-Z0-9 ]+$/.test(this.newProduct.name)) {
                this.productError = this.__('Product field Required! (only characters and numbers allowed)');
                setTimeout(() => { this.productError = null; }, 2500);
                return;
            }
            else if (this.newProduct.avatar == null) {
                this.productError = this.__('Image is required! (you may select one image)');
                setTimeout(() => { this.productError = null; }, 2500);
                return;
            }

            this.newProduct.post(route('product.create', this.currentCategory.id), {
                preserveState: true,
                onSuccess: () => {
                    this.newProduct.reset();
                    this.avatar = null;
                    this.products.push(this.$page.props.flash.data);
                    setTimeout(() => { this.$page.props.flash.successTwo = null; }, 2500);
                }
            });

        },

        deleteProduct(product, index) {
            router.delete(route('product.delete', product), {
                preserveState: true,
                onBefore: () => confirm(this.__('Are you sure you want to delete this product?')),
                onSuccess: () => {
                    if (!this.$page.props.flash.error) {
                        this.products.splice(index, 1);
                        setTimeout(() => { this.$page.props.flash.successTwo = null; }, 2500);
                    } else {
                        setTimeout(() => { this.$page.props.flash.error = null; }, 2500);
                    }
                }
            });
        },

        EditCategory() {
            if (!/^[a-zA-Z0-9 ]+$/.test(this.currentCategory.name)) {
                this.categoryError = this.__('Category field Required! (only characters and numbers allowed)');
                setTimeout(() => { this.categoryError = null; }, 2500);
                return
            }

            router.put(route('category.update', this.currentCategory.id), { name: this.currentCategory.name }, {
                preserveState: true,
                onSuccess: () => {
                    setTimeout(() => { this.$page.props.flash.successTwo = null; }, 2500);
                }
            });
        },

        uploadFile(event) {
            this.productError = null;

            const file = event.target.files[0];


            if (!file.type.match("image.*")) return;

            const reader = new FileReader();

            reader.onload = (e) => this.avatar = e.target.result;

            reader.readAsDataURL(file);

            this.newProduct.avatar = file;
        },

        closeModal() {
            this.$emit('ClosingModal', false);
        },
    }
}
</script>