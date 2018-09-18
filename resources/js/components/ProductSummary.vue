<template>
    <div class="product card text-left" style="max-width: 300px; min-width: 200px;">
        <router-link :to="{ name: 'product', params: { 'id': product.id }}">
            <img v-if="product.thumbnail" :src="product.thumbnail.image_url + '?300x300'" class="card-img-top">
        </router-link>
        <div class="card-body">
            <div class="product--name card-title">{{ product.name }}</div>
        </div>
        <ul class="list-group list-group-flush">
            <router-link tag="li" class="list-group-item text-center" :to="{ name: 'product', params: { 'id': product.id }}">
                <a class="d-block" :id="'product_link_' + product.id">View Details</a>
            </router-link>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['product']
    }
</script>
