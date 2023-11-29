<template>
    <div class="w-10/12 mx-auto rounded">
        <img src="/images/logos/logo2.png"
            draggable="false"
            class="w-full mx-auto" 
        />

    </div>
</template>
<script>
export default {
props:{
    white: String,
}
}
</script>

<style scoped>
.svg{
border:0.5px solid gray;
background: lightgray;
min-width: 50px!important;
padding: 10px;
height: 50px;
margin-right: 8px;
border-radius: 50%;
}
</style>