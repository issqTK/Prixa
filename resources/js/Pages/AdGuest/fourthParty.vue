<template>
    <div class="w-full flex flex-col gap-8 overflow-auto p-2">
        
        <div>
            <label for="phone-action" class="flex items-center gap-2 text-gray-900 font-semibold">
                {{__('Phone')}}
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.phone" class="text-sm text-red-400 ">{{this.errors.phone}}</span>
                </div>
            </label>

            <input 
                @input="$emit('update:phone', $event.target.value)"
                :value="phone" 
                type="number"  
                id="phone-action"
                class="w-full rounded border-gray-200"
                :class="classes"
            >
        </div>

        <div>
            <label for="whatsapp-action" class="flex items-center gap-2 text-gray-900 font-semibold">
                {{ __('Whatsapp') }}
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.whatsapp" class="text-sm text-red-400 ">{{this.errors.whatsapp}}</span>
                </div>
            </label>

            <input 
                @input="$emit('update:whatsapp', $event.target.value)"
                :value="whatsapp" 
                type="number" 
                id="whatsapp-action" 
                class="w-full rounded border-gray-200"
                :class="classes"
            >
        </div>

        <div>
            <label for="shop-action" class="flex items-center gap-2 text-gray-900 font-semibold">
                {{ __('Shop Address') }}
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.shop" class="text-sm text-red-400 ">{{this.errors.shop}}</span>
                </div>
            </label>

            <input 
                @input="$emit('update:shop', $event.target.value)"
                :value="shop" 
                type="url" 
                id="shop-action" 
                class="w-full rounded border-gray-200"
                :class="classes"
            >
        </div>         
    </div>
</template>

<script>
export default {
    props: ['phone','whatsapp','shop','errors','classes'],
    emits: ['update:phone','update:whatsapp','update:shop']
}
</script>