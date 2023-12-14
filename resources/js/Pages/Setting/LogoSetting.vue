<template>
    <div class="">
        <h3 class="text-lg uppercase text-zinc-700 font-bold mb-3">Logo Settings</h3>
        
        <div v-if="this.Success" class="text-white font-semibold text-sm bg-zinc-600 p-2 rounded text-center"> 
            {{ this.Success }} 
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4">
            <div class="group relative pt-6 p-4 bg-white shadow rounded overflow-hidden">
                <h4 class="absolute top-0 left-2/4 -translate-x-2/4 w-full text-sm font-semibold text-zinc-900 bg-zinc-200 rounded-t text-center">
                    Logo Front Office
                </h4>

                <img :src="this.frontLogo == null 
                    ? '/images/logos/' + this.logos.frontLogo
                    : this.frontLogo"
                    draggable="false">

                <input id="front" type="file" class="hidden" @change="uploadLogoFront($event)">
                
                <label for="front" class="absolute left-0 right-0 h-full -top-full group-hover:top-0  font-semibold text-zinc-50 flex items-center justify-center cursor-pointer transition-all" style="background-color: #18181b16; backdrop-filter: blur(10px);">
                    Upload New Logo
                </label>
            </div>

            <div class="group relative pt-6 p-4 bg-white shadow rounded overflow-hidden">
                <h4 class="absolute -top-0 left-2/4 -translate-x-2/4 w-full text-sm font-semibold text-zinc-900 bg-zinc-200 rounded-t text-center">
                    Logo Back Office
                </h4>
                <img :src="'/images/logos/' + this.logos.backLogo" draggable="false">

                <input id="back" type="file" class="hidden"  @change="uploadLogoBack($event)">
                
                <label for="back" class="absolute left-0 right-0 h-full -top-full group-hover:top-0  font-semibold text-zinc-50 flex items-center justify-center cursor-pointer transition-all" style="background-color: #18181b16; backdrop-filter: blur(10px);">
                    Upload New Logo
                </label>
            </div>

            <div class="group relative pt-6 p-4 bg-white shadow rounded overflow-hidden">
                <h4 class="absolute -top-0 left-2/4 -translate-x-2/4 w-full text-sm font-semibold text-zinc-900 bg-zinc-200 rounded-t text-center">
                    Logo Favicon
                </h4>

                <img 
                    :src="this.faviconLogo == null 
                    ? '/images/logos/' + this.logos.faviconLogo 
                    : this.faviconLogo"
                    draggable="false">

                <input id="favicon" type="file" class="hidden"  @change="uploadLogofavicon($event)">
                
                <label for="favicon" class="absolute left-0 right-0 h-full -top-full group-hover:top-0  font-semibold text-zinc-50 flex items-center justify-center cursor-pointer transition-all" style="background-color: #18181b16; backdrop-filter: blur(10px);">
                    Upload New Logo
                </label>
            </div>

        </div>
    </div>

</template>

<script>
import { router } from '@inertiajs/vue3'

export default {
    props:['logos'],

    data() {
        return {
            Success: null,
            frontLogo: null,
            backLogo: null,
            faviconLogo: null,
        }
    },

    methods:{
        uploadLogoFront(event) {
            const file = event.target.files[0];


            if (!file.type.match("image.*")) return;

            const reader = new FileReader();

            reader.onload = (e) => this.frontLogo = e.target.result;

            reader.readAsDataURL(file);

            router.post(route('update.frontLogo'), {'file':file}, {
                preserveState: true,
                onSuccess: () => {
                    this.Success = this.__('Successfully updated');

                    setTimeout(() => { this.Success = null; }, 2500);
                },
            })


        },
        uploadLogoBack(event) {
            const file = event.target.files[0];


            if (!file.type.match("image.*")) return;

            const reader = new FileReader();

            reader.onload = (e) => this.backLogo = e.target.result;

            reader.readAsDataURL(file);

            router.post(route('update.backLogo'), {'file':file}, {
                preserveState: true,
                onSuccess: () => {
                    this.Success = this.__('Successfully updated');

                    setTimeout(() => { this.Success = null; }, 2500);
                },
            })


        },

        uploadLogofavicon(event) {
            const file = event.target.files[0];


            if (!file.type.match("image.*")) return;

            const reader = new FileReader();

            reader.onload = (e) => this.faviconLogo = e.target.result;

            reader.readAsDataURL(file);

            router.post(route('update.faviconLogo'), {'file':file}, {
                preserveState: true,
                onSuccess: () => {
                    this.Success = this.__('Successfully updated');

                    setTimeout(() => { this.Success = null; }, 2500);
                },
            })


        }
    }
}
</script>