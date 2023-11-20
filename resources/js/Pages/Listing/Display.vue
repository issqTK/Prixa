<template>
    <Head title="Manage Listings" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-black leading-tight">
                Listings Manager
            </h1>
        </template>

        <div class="py-9">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="page.props.flash.success" class="w-full rounded mb-4 p-6 text-center text-lg bg-emerald-500 text-white font-semibold">
                    {{ page.props.flash.success }}
                </div>

                <div id="content" class="relative overflow-hidden sm:rounded-lg sm:shadow-xl mb-4">

                    <h2 class="flex items-center gap-3 px-4 py-3 text-xl font-bold bg-zinc-200">
                        <span class="material-icons-outlined">featured_play_list</span> 
                        All Listings
                    </h2>

                    <Link :href="route('listing.create')" 
                        class="absolute top-1.5 right-4 inline-flex items-center justify-center gap-2 py-2 px-4 text-xs font-bold tracking-wide uppercase hover:bg-zinc-950 bg-transparent text-zinc-950 hover:text-zinc-50 transition-all easy-in-out rounded border border-zinc-950">
                        
                        <span class="material-icons-outlined min-w-min">playlist_add</span>
                        New Listing
                    </Link>
                    
                    <div class="py-4 px-6 flex flex-col gap-4">
                        <div v-if="listings.length > 0" v-for="listing in listings" :key="listing.id" 
                            class="grid grid-cols-5 md:grid-cols-6 p-2 relative cursor-pointer rounded overflow-hidden border bg-zinc-100 border-zinc-300">

                            <!-- Actions -->
                            <div class="absolute top-0 bottom-0 left-0 right-0 flex">
                                <div class="w-6/12 flex group">
                                    <Link 
                                        :href="route('listing.edit', listing.id)"
                                        class="w-full hidden group-hover:flex items-center justify-center bg-zinc-900 animate-pulse transition-all font-bold text-white capitalize rounded-l">
                                        Click to Edit
                                    </Link>
                                </div>

                                <div class="w-6/12 flex group">
                                    <button @click.prevent="deletAd(listing.id)"
                                        class="w-full hidden group-hover:flex items-center justify-center bg-rose-700 animate-pulse transition-all font-bold text-white capitalize rounded-r"
                                    >
                                        Click To Delete
                                    </button>
                                </div>
                            </div>

                            <h3 class="col-span-3 md:col-span-4 flex gap-2 items-center text-md font-semibold capitalize rounded-t">
                                <img :src="'/storage/images/listings/' + listing.avatar" class="w-8" draggable="false">
                                {{ listing.title }}
                            </h3>

                            <span class="flex items-center w-auto justify-start gap-1 font-bold" >
                                <span class="material-icons-outlined" style="font-size:1.1em">pin_drop</span>
                                <span style="font-size:.8em">{{ listing.city }}</span>
                            </span>

                            <span class="flex items-center justify-end gap-1 font-bold"> 
                                <span style="font-size:.8em">{{listing.product_count}}</span>
                                <span class="material-icons-outlined" style="font-size:1.1em">category</span>
                            </span>
                        </div>
                        
                        <div v-else>There is no listings yet</div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { Head, Link, usePage, router } from "@inertiajs/vue3";
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps(['listings']);

const page = usePage();

const deletAd = (listing) => {
    router.delete(route('listing.delete', listing), {
        onBefore: () => confirm('Are you sure you want to delete this Listing?'),
        onSuccess: () => setTimeout(() => { page.props.flash.success = null;}, 2500),
    });
}

</script>