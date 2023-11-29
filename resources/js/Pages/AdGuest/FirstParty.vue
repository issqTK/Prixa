<template>
    <div class="w-full flex flex-col gap-8 overflow-auto p-2">
        
        <div class="relative">
            <label for="productName" class="flex gap-2 items-center font-semibold text-gray-900">
                {{__('Product')}} 
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.product" class="text-sm text-red-400 ">{{this.errors.product}}</span>
                </div>
            </label>

            <input 
                @keyup="fetchProducts"
                type="search" 
                id="productName" 
                placeholder="Iphone, Samsung.." 
                class="w-full rounded border-gray-200"
                :class="classes"
                >
            
            <div v-if="selected == true"
                class="absolute flex gap-2 items-center px-2 leading-10 bg-slate-100 rounded" style="bottom: .5px;left: 1px;">
                <img :src="'/images/phones/' + this.selectedProduct.avatar" class="h-9">
                <span>{{ selectedProduct.name }}</span>
                
                <span @click="releaseProduct"
                    class="flex items-center justify-center absolute w-4 font-bold leading-4 -right-1 -top-1 text-sm -rotate-45 text-white hover:bg-red-500 bg-red-400 rounded-full cursor-pointer">
                    +
                </span>
            </div>
        </div>

        <div class="flex flex-wrap p-4 gap-4 justify-center rounded bg-slate-100">
                
            <div v-for="(product, index) in products" :key="index"
                @click="this.selectProduct(product)"
                class="flex flex-col justify-between w-3/12 sm:w-2/12 p-2 rounded bg-white cursor-pointer">

                <span class="block w-full text-sm text-center">{{ product.name }}</span>

                <img class="block w-full" :src="'/images/phones/'+product.avatar">

            </div>
            
        </div>

        <div>
            <label for="city" class="flex gap-2 items-center font-semibold text-gray-900">
                {{__('City')}}
                <div class="flex items-center gap-1">
                    <span class="text-red-400 pt-1.5">*</span> 
                    <span v-show="this.errors.city" class="text-sm text-red-400 ">{{this.errors.city}}</span>
                </div>
            </label>
            
            <select @change="this.$emit('city', $event.target.value)"
                v-model="this.selectedCity"
                id="city" 
                :class="classes"
                class="w-full rounded border-gray-200 cursor-pointer text-gray-700">
                <option selected disabled value="null">{{__('Choose City')}}</option>
                <option v-for="(city,index) in cities" :key="index"  :value="city.id">{{city.name}}</option>
            </select>
            
        </div>
    </div>
</template>

<script>
export default {
    props:['product','city','errors', 'classes'],
    data() {
        return {
            selected: false,
            selectedProduct: [],
            products: [],
            cities: [],
            selectedCity: this.city
        }
    },
    methods: {
        fetchProducts() {
            var string = document.getElementById('productName').value;

            if( string.length <= 0 ) {
                this.products = [];
                return
            }
            
            axios
            .get('/api/get-product-filter/'+ string)
            .then(response => {
                this.products = response.data;
            });
        },
        selectProduct(product){
            this.selectedProduct = product;

            this.selected = true;

            this.products = [];

            document.getElementById('productName').setAttribute('disabled' , true);

            this.$emit('product', product);
        },
        releaseProduct() {
            this.selected = false;

            document.getElementById('productName').removeAttribute('disabled');

            this.$emit('product', null);
        }
    },
    mounted() {
        if( this.product != null )
            this.selectProduct(this.product);

        axios.get('api/get-cities-all').then(response => {
            this.cities = response.data;
        });
    }
}
</script>