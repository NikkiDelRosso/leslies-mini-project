<template>
    <div class="mt-5" :id="'product_' + id">
        <router-link :to="{ name: 'home' }">&lt; Back to all products</router-link>
        <div v-if="!loaded">Loading...</div>
        <div v-elseif="product">
            <div class="product-details clearfix mb-5">
                <div class="float-md-left mr-md-3" v-if="product.images.length > 0">
                    <img :src="getImage(this.selectedThumbnail)" ref="image" class="img-fluid">
                    <div v-if="product.images.length > 1" class="thumbnails row">
                        <div class="col mt-3">
                            <img class="mr-2 thumbnail"
                                v-bind:key="image.image_url"
                                v-for="(image, index) in product.images"
                                :src="image.image_url + '?50x50'"
                                :class="selectedThumbnail == index? 'active' : ''"
                                @click="selectedThumbnail = index">
                        </div>
                    </div>
                </div>
                <h1>{{ product.name }}</h1>
            
                {{ product.description }}
            </div>
            <div v-if="relatedProducts.length > 0">
                <h2>You may also be interested in...</h2>
                <div class="row text-center">
                    <div class="col col-md-4 col-lg-3 mb-3 d-flex align-items-stretch" v-for="related in relatedProducts.slice(0, 4)" v-bind:key="related.product.id">
                        <product-summary :product="related.product"></product-summary>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                id : this.$route.params.id,
                loaded: false,
                product: null,
                relatedProducts: [],
                selectedThumbnail: 0
            }
        },
        methods: {
            loadProductDetails() {
                this.$http.get('products/' + this.id).then((response) => {
                    this.product = response.data.product
                    this.relatedProducts = response.data.related_products
                    this.loaded = true
                })
            },
            getImage(index) {
                if (index >= this.product.images.length) {
                    return
                }

                let img = this.product.images[index]
                return img.image_url + '?500x500'
            }
        },
        created() {
            this.loadProductDetails()
        }
    }
</script>
