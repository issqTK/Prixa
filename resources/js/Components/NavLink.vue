<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'background: hsla(0,0%,100%,.23)'
        : ''
);
</script>

<template>
    <Link :href="href" :style="classes" class="hc flex items-center gap-2 w-full p-4 uppercase text-xs text-white font-bold  rounded transition-all duration-300">
        <slot />
    </Link>
</template>

<style scoped>
.hc:hover{
    background: hsla(0,0%,100%,.15)
}
</style>
