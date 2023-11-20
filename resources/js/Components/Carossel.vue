<template>
    <div id="slider" class="overflow-hidden">
        <div class="relative overflow-hidden h-full">
            <div
                v-for="(img, i) in images"
                :id="`slide-${i}`"
                :key="i"
                :class="`${active === i ? 'active' : 'left-full'}`"
                class="carousel-item inset-0 relative h-full transform transition-all duration-500 ease-in-out"
            >
                <img class="block w-full" :src="img" draggable="false" />
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            images: ["/images/carossel/1.png"],
            active: 0,
        };
    },
    mounted() {
        let i = 0;
        setInterval(() => {
            if (i > this.images.length - 1) {
                i = 0;
            }
            this.active = i;
            i++;
        }, 2500);
    },
};
</script>

<style scoped>
.left-full {
    left: -100%;
}

.carousel-item {
    float: left;
    position: relative;
    display: block;
    width: 100%;
    margin-right: -100%;
    backface-visibility: hidden;
}

.carousel-item.active {
    left: 0;
}
</style>
