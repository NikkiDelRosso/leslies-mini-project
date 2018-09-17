<template>
    <div class="home">
        <h1>{{ title }}</h1>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-if="productList.length > 0">
                <product-summary
                    v-for="product in productList"
                    v-bind:key="product.id"
                    :product="product"></product-summary>
            </div>
            <div v-else><em>There are no products to show you!</em></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title'],
        data() {
            return {
                'productList': [],
                'loading': true
            }
        },
        methods: {
            loadProductList() {
                this.$http.get('products').then((response) => {
                    this.productList = response.data.products
                    this.loading = false
                    console.log(this.productList)
                })
            }
        },
        created() {
            this.loadProductList()
        }
    }
</script>
