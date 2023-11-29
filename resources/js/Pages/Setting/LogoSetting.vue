<template>
    <div class="">
        <h3 class="text-lg uppercase text-zinc-700 font-bold mb-3">Logo Settings</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4">
            <div class="relative p-4 bg-white shadow rounded">
                <h4 class="absolute -top-5 left-2/4 -translate-x-2/4 w-8/12 text-sm font-semibold text-zinc-900 bg-zinc-200 rounded-t text-center">
                    Logo Front Office
                </h4>
                <img :src="'/images/logos/' + this.logos.frontLogo" draggable="false">
            </div>

            <div class="relative p-4 bg-white shadow rounded">
                <h4 class="absolute -top-5 left-2/4 -translate-x-2/4 w-8/12 text-sm font-semibold text-zinc-900 bg-zinc-200 rounded-t text-center">
                    Logo Back Office
                </h4>
                <img :src="'/images/logos/' + this.logos.backLogo" draggable="false">
            </div>

            <div class="relative p-4 bg-white shadow rounded">
                <h4 class="absolute -top-5 left-2/4 -translate-x-2/4 w-8/12 text-sm font-semibold text-zinc-900 bg-zinc-200 rounded-t text-center">
                    Logo Favicon
                </h4>
                <img :src="'/images/logos/' + this.logos.faviconLogo" draggable="false">
            </div>

        </div>
    </div>

</template>

<script>
export default {
    props:['logos']
}
</script>