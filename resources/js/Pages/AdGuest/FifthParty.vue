<template>
    <div class="w-full flex flex-col gap-8 overflow-auto p-2">
        
        <div>
            <label for="username" class="flex gap-2 items-center font-semibold text-gray-900">
                {{__('Name')}}
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.fullName" class="text-sm text-red-400 ">{{this.errors.fullName}}</span>
                </div>
            </label>
            
            <input 
                @input="$emit('update:fullName', $event.target.value)"
                :value="fullName"
                type="text" 
                id="username" 
                class="w-full rounded border-gray-200"
                :class="classes"
            >
        </div>

        <div>
            <label for="email" class="flex gap-2 items-center font-semibold text-gray-900">
                {{__('Email')}} 
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.email" class="text-sm text-red-400 ">{{this.errors.email}}</span>
                </div>
            </label>
            
            <input 
                @input="$emit('update:email', $event.target.value)"
                :value="email"
                type="text" 
                id="email" 
                class="w-full rounded border-gray-200"
                :class="classes"
            >
        </div>

        <div>
            <label for="password" class="flex gap-2 items-center font-semibold text-gray-900">
                {{ __('Password') }}
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.password" class="text-sm text-red-400 ">{{this.errors.password}}</span>
                </div>
            </label>
            
            <input 
                @input="$emit('update:password', $event.target.value)"
                type="password" 
                id="password" 
                class="w-full rounded border-gray-200"
                :class="classes"
                autocomplete="on"
            >
        </div>
        
        <div>
            <label for="passwordConfirm" class="flex gap-2 items-center font-semibold text-gray-900">
                {{__('Confirm Password')}}
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.passwordConfirm" class="text-sm text-red-400 ">{{this.errors.passwordConfirm}}</span>
                </div>
            </label>
            
            <input 
                @input="$emit('update:passwordConfirm', $event.target.value)"
                type="password" 
                id="passwordConfirm" 
                class="w-full rounded border-gray-200"
                :class="classes"
                autocomplete="on"
            >
        </div>
    </div>
</template>

<script>
export default {
    props:['fullName','email','errors', 'classes'],
    emits:['update:fullName','update:email','update:password','update:passwordConfirm'],

}
</script>