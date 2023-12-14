<template>
    <div  class="rounded">
        <img :src="'/images/logos/' + img" draggable="false" class="w-full mx-auto" />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

const img = ref();

onMounted(() => {
    axios.get("/api/get-admin-logo").then((response) => {
        img.value = response.data.frontLogo;
    });
});
</script>