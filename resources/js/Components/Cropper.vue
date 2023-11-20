<script setup>
import { ref } from 'vue';
import { reactive } from 'vue'
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';


const img = ref('')
const image = ref('')
const data = reactive({ show: false });
const emit = defineEmits(['is-emit']);

const change = ( {coordinates, canvas } ) => {
    //console.log(coordinates, canvas);
    image.value = canvas.toDataURL();
}

const uploadFile = (e) => {
    var reader,
        files = e.target.files;

    reader = new FileReader();
    reader.onload = (e) => {
        img.value = e.target.result;
        data.show = true;
    };

    reader.readAsDataURL(files[0]);
}

const submitFile = () => {
    if (image.value === "")
        return

    var arr = image.value.split(","),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);

    while (n--)
        u8arr[n] = bstr.charCodeAt(n);

    var file = new File([u8arr], "filename.png", { type: mime });

    emit('is-emit', file);

    data.show = false;
}
</script>

<template>
    <div v-if="data.show == true" class="fixed flex items-start justify-between gap-6 p-12 bg-zinc-300 z-10"
        style="top:0px; bottom:0; left: 0; right: 0;">
        
        <cropper class="w-8/12" :src="img" :stencil-props="{ aspectRatio: 10 / 10 }" @change="change" />
        
        <div class="flex-1 flex flex-col gap-6">
            <img :src="image" alt="" class="w-full rounded-full">

            <button @click="submitFile" class="py-4 px-6 rounded text-white font-bold bg-cyan-500">Save</button>
        </div>

        <span @click="data.show = false" class="material-icons-outlined absolute right-2 top-2 text-red-500 cursor-pointer rounded-full hover:bg-red-500 hover:text-zinc-300 transition-all">close</span>
    </div>

    <input type="file" id="file" placeholder="upload" @change="uploadFile" rel="file" class="hidden" />
</template>