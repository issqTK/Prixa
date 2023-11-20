<template>
    <div class="fixed top-0 bottom-0 right-0 left-0 bg-transparent z-10" v-if="show" @click="showProducts"></div>

    <div class="relative w-full mt-1 p-1 flex border border-gray-300 bg-white rounded !z-50"
        :class="{'!border-red-500' : error}">
        <div v-if="selected.length == 0" class="flex items-center flex-auto flex-wrap">
            <div class="text-9 px-2">
                Choose Products
            </div>
        </div>
        <div v-else class="flex items-center flex-auto flex-wrap">
            <div v-for="(product,item) in selected" :key="item" class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-full text-zinc-700 bg-zinc-100 border border-zinc-300 ">
                <div class="text-9 font-normal leading-none max-w-full flex-initial">{{product.name}}</div>
                <div class="flex flex-auto flex-row-reverse">
                    <div >
                        <svg @click="unSelect(product.id, item)"
                            xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-zinc-400 rounded-full w-4 h-4 ml-2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-300 ">
            <button @click.prevent="showProducts" class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up w-4 h-4">
                    <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
            </button>
        </div>
    </div>
    
    <div v-show="show" class="relative w-full z-50">
        <div class="flex flex-col items-center relative">
            
            <div class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto ">
                <div class="flex flex-col w-full">
                    <div 
                        v-for="product in products" 
                        :key="product.id" 
                        :id="product.id"
                        @click="select(product)"
                        class="product-item cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-zinc-100">

                        <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-zinc-300">
                            <div class="w-full items-center flex">
                                <div class="mx-2 leading-6  text-9">{{ product.name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template> 

<script setup>
import { ref, onUpdated } from 'vue';

const props = defineProps(['products','error', 'reset','selectedProducts']);

const emit = defineEmits(['selectProduct', 'unSelectProduct', 'reseted']);

var show = ref(false);

const showProducts = () => { show.value = !show.value }

const affected = ref(true);

const selected = ref([]);

const select = (product) => {
    var div = document.getElementById(product.id).firstChild;
    
    if(div.classList.contains('!border-zinc-500'))
        return;

    selected.value.push(product);

    emit('selectProduct', product.id)

    div.classList.add('!border-zinc-500');
}

const unSelect = (product, item) => {
    selected.value.splice(item, 1);

    emit('unSelectProduct', product)

    document.getElementById(product).firstChild.classList.remove('!border-zinc-500');
}

onUpdated(() => {
    if(props.selectedProducts && affected.value == true) {
        
        props.selectedProducts.forEach(product => {
            selected.value.push(product);
            document.getElementById(product.id).firstChild.classList.add('!border-zinc-500')
        })

        affected.value = false;

    }
    if(props.reset == true)
    {
        selected.value.splice(0);
        
        var items =  document.querySelectorAll('.product-item');

        items.forEach((item) => {
            if( item.firstChild.classList.contains('!border-zinc-500') )
                item.firstChild.classList.remove('!border-zinc-500');
        });

        emit('reseted', false);
    }
})
</script>

<style scoped>
    .text-9{font-size: .9em;}
    .top-100 {top: 100%}
    .bottom-100 {bottom: 100%}
    .max-h-select {
        max-height: 300px;
    }
</style>