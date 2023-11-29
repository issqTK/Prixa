<template>
    <Link 
        :href="href" 
        :class="classes"
        class="w-full px-2 sm:px-4 py-2 sm:p3 flex gap-2 items-center group uppercase text-xs font-bold text-slate-800 hover:text-slate-50 bg-gradient-to-r hover:from-slate-700 hover:via-slate-500 hover:to-slate-500 rounded border"
    >
        <slot />
    </Link>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Link,
    },

    props: ['href', 'active'],

    computed: {
        classes() {
            return this.active
                ? '!text-slate-50 !from-slate-700 !via-slate-500 !to-slate-500'
                : ''
        }
    }
}
</script>