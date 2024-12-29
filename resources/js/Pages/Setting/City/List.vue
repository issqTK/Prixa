<template>
    <div class="relative rounded sm:rounded-lg shadow sm:shadow-xl">
        <h3 class="absolute text-lg uppercase font-bold left-0 -top-10 text-zinc-700">{{ __('City Settings') }}</h3>

        <button @click.prevent="ShowingModal = true"
            class="absolute -top-12 right-2 inline-flex items-center justify-center gap-2 py-2 px-4 text-xs font-bold tracking-wide uppercase hover:bg-zinc-950 bg-transparent text-zinc-950 hover:text-zinc-50 transition-all easy-in-out rounded border border-zinc-950">
            <span class="material-icons-outlined min-w-min">playlist_add</span>
            {{ __('New City') }}
        </button>

        <div v-if="$page.props.flash.successTwo"
            class="text-white font-semibold text-sm bg-zinc-600 p-2 rounded absolute right-0 bottom-2/4 translate-y-2/4 z-10">
            {{ $page.props.flash.successTwo }}
        </div>

        <!-- header -->
        <div class="grid grid-cols-5 flex items-center text-base font-bold rounded-t-md divide-x divide-white text-zinc-900 bg-zinc-200"
            id="city-header">
            <span class="col-span-4 text-center">{{ __('List Cities') }}</span>
            <span class="text-center">{{ __('Delete') }}</span>
        </div>


        <!-- content -->
        <div v-if="cities.length > 0" v-for="(city, index) in cities" :key="city.id"
            class="grid grid-cols-5 items-center px-4 py-2 hover:bg-zinc-100 ">
            <span class="col-span-4 text-center">{{ city.name }}</span>

            <button @click.prevent="deleteCity(city.id, index)" class="text-sm font-semibold text-rose-500">
                {{ __('Delete') }}</button>
        </div>
        <div v-else class="p-2">{{ __('There is no Cities yet!') }}</div>
    </div>

    <Modal :show="ShowingModal" @close="closeModal">
        <div class="p-4">
            <div v-if="$page.props.flash.successThree"
                class="bg-zinc-600 text-white rounded text-sm opacity-80 w-8/12 text-center py-2 font-semibold absolute top-0 right-2/4 p-2 translate-x-2/4">
                {{ $page.props.flash.successThree }} </div>

            <!-- City -->
            <div class="mb-4">
                <InputLabel for="city" class="mb-1 text-zinc-900">{{ __('City') }}</InputLabel>

                <div class="flex gap-4 mt-1">
                    <TextInput v-model="city.name" @keyup="cityError = null" id="city" class="flex-1 text-sm"
                        :placeholder="__('City')"></TextInput>

                    <BreezeButton @click.prevent="createCity">{{ __('save') }}</BreezeButton>
                </div>

                <div v-if="cityError"
                    class="text-sm font-semibold opacity-80 text-white bg-rose-500 p-2 rounded absolute top-0 right-2/4 translate-x-2/4">
                    {{ cityError }}
                </div>
               
            </div>
        </div>
    </Modal>
</template>

<script>
import { router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import BreezeButton from "@/Components/PrimaryButton.vue";


export default {
    components: { Modal, InputLabel, TextInput, BreezeButton },
    data() {
        return {
            cities: [],
            ShowingModal: false,
            cityError: null,
            city: useForm({
                name: '',
            })
        }
    },
    methods: {
        createCity() {
            if (!/^[a-zA-Z0-9 ]+$/.test(this.city.name)) {
                this.cityError = this.__('City field Required! (only characters and numbers allowed)');
                setTimeout(() => { this.cityError = null; }, 2500);
                return
            }

            router.post(route('city.create', this.city.name), {}, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    if( this.$page.props.flash.error_two != null ) {
                        this.cityError = this.$page.props.flash.error_two;
                        setTimeout(() => { this.cityError = null; }, 2500);
                        this.city.reset();
                        return;
                    }
                    this.city.reset();
                    setTimeout(() => { this.$page.props.flash.successThree = null; }, 2500);
                    this.cities.push(this.$page.props.flash.data);
                }
            });
        },
        deleteCity(city, index) {
            router.delete(route('city.delete', city), {
                preserveState: true,
                preserveScroll: true,
                onBefore: () => confirm(this.__('Are you sure you want to delete this city?')),
                onSuccess: () => {
                    if (!this.$page.props.flash.error_two) {
                        this.cities.splice(index, 1);
                        setTimeout(() => { this.$page.props.flash.successTwo = null; }, 2500);
                    } else {
                        setTimeout(() => { this.$page.props.flash.error_two = null; }, 2500);
                    }
                }
            });
        },
        closeModal() {
            this.ShowingModal = false;
        }
    },
    mounted() {
        axios.get("/api/get-cities-all").then((response) => this.cities = response.data);
    }
}
</script>

<style scoped>
#city-header>span {
    padding: 10px 0;
}
</style>