<template>
    <div class="w-full flex flex-col gap-8 overflow-auto p-2">
        
        <div>
            <label for="title" class="flex items-center gap-2 text-gray-900 font-semibold">
                {{__('Title')}} 
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.title" class="text-sm text-red-400 ">{{this.errors.title}}</span>
                </div>
            </label>

            <input @input="$emit('title', $event.target.value)"
                :value="this.title"
                type="text" 
                id="title" 
                class="w-full rounded border-gray-200" 
                :class="classes"
                />
        </div>

        <div>
            <label for="description" class="flex items-center gap-2 text-gray-900 font-semibold">
                {{ __('Description') }}
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.description" class="text-sm text-red-400 ">{{this.errors.description}}</span>
                </div>
            </label>
            
            <textarea @input="$emit('description', $event.target.value)"
                :value="this.description"
                id="description" 
                class="w-full rounded border-gray-200" 
                :class="classes"
                cols="30" 
                rows="6" 
            ></textarea>
        </div>

        <div>
            <label for="price" class="flex items-center gap-2 text-gray-900 font-semibold">
                {{ __('Price') }}
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.price" class="text-sm text-red-400 ">{{this.errors.price}}</span>
                </div>
            </label>

            <input @input="$emit('price', $event.target.value)"
                :value="this.price"
                type="number" 
                id="price" 
                class="w-full rounded border-gray-200"
                :class="classes">
        </div>
    </div>
</template>

<script>
export default {
    props:['title','description','price','errors', 'classes'],
    emits:['title','description','price'],
}
</script>