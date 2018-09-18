<template>
    <div class="home">

        <header class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">{{ title }}</h1>
            </div>
        </header>
        <div class="container">
            <div v-if="loading">Loading...</div>
            <div v-else>
                <div v-if="productList.length > 0" class="products row">
                    <div class="col col-md-4 col-lg-3 mb-3 d-flex align-items-stretch" v-for="product in productList"
                        v-bind:key="product.id">
                            <product-summary :product="product"></product-summary>
                    </div>
                </div>
                <div v-else><em>There are no products to show you!</em></div>
            </div>
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
        mounted() {
            this.loadProductList()
        }
    }
</script>
