<template>
    <div class="product">
        <img v-if="product.thumbnail" :src="product.thumbnail.image_url + '?200x200'">
        <div class="product--name">{{ product.name }}</div>
        <div class="product--brand">Brand: {{ product.brand }}</div>
    </div>
</template>

<script>
    export default {
        props: ['product']
    }
</script>
