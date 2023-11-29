<template>
    <div class="w-full flex flex-col gap-8 overflow-auto p-2">
        
        <div class="flex items-center justify-between">
            <input @change="onFilesChange" class="hidden" type="file" id="files" multiple>
            
            <label for="files" 
                class="inline-flex flex-col p-4 items-center rounded bg-slate-100 cursor-pointer">
                
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                
                <span>{{__('Choose Images')}}</span>
            </label>

            <span v-show="errors" class="text-sm text-red-400 font-semibold">{{errors}}</span>
            <span v-show="errorEmpty" class="text-sm text-red-400 font-semibold">{{errorEmpty}}</span>
        </div>

        <hr> 

        <span class="text-gray-700 text-sm capitalize">{{ __('Recommended image size square of (320 x 320 px)') }}</span>

        <div class="grid grid-cols-4 w-full gap-3 p-4 justify-center" >
            <div v-for="(image, index) in images" :key="index" class="h-24 sm:h-32 flex items-center justify-center bg-slate-200 overflow-hidden rounded" >
                <img :src="image" class="greatH" >
            </div>
        </div>           
    </div>
</template>

<script>
export default {
    props: ['errorEmpty'],
    emits: ['file'],
    data() {
        return {
            errors: null,
            images: [],
            listFilesName: [],
        }
    },
    methods: {
        onFilesChange(e) {
            const files = e.target.files;

            if(files.length > 8) {
                this.errors = 'only 8 pictures allowed!';

                setTimeout(() => { this.errors = null }, 2000);

                return
            }

            Array.from(files).forEach((file) => {
                if(this.listFilesName.includes(file.name)) return;

                this.listFilesName.push(file.name);

                if(!file.type.match('image.*')) {
                    this.errors = 'only valid images allowed!';
                    setTimeout(() => { this.errors = null }, 3000);
                }

                else if(this.images.length > 7) {
                    this.errors = 'only 8 pictures allowed!';
                    setTimeout(() => { this.errors = null }, 3000);
                    return
                }

                else {
                    const reader = new FileReader();
                    
                    reader.onload = (e) => this.images.push(e.target.result);
                    
                    reader.readAsDataURL(file)

                    this.$emit('file', file);
                }
            });
        },
    }
}
</script>

<style>
.greatH {
    max-width: 100%;
    max-height: 100%;
}
</style>