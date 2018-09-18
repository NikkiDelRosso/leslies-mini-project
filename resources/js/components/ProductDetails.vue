<template>
    <div class="my-5 container" :id="'product_' + id">
        <div v-if="!loaded" class="mb-5">Loading...</div>
        <div v-else-if="product">
            <div class="product-details mb-5 row">
                <div class="col-12 col-md-6">
                    <div class="mr-md-3 mb-3" v-if="product.images.length > 0">
                        <img :src="getImage(this.selectedThumbnail)" ref="image" class="img-fluid">
                        <div v-if="product.images.length > 1" class="thumbnails row">
                            <div class="col mt-3">
                                <img class="mr-2 mb-2 thumbnail"
                                    v-bind:key="image.image_url"
                                    v-for="(image, index) in product.images"
                                    :src="image.image_url + '?50x50'"
                                    :class="selectedThumbnail == index? 'active' : ''"
                                    @click="selectedThumbnail = index">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <h1>{{ product.name }}</h1>

                    <ul class="list-group">
                        <li class="list-group-item">Brand: {{ product.brand }}</li>
                        <li class="list-group-item">Type: {{ product.type }}</li>
                    </ul>
                
                    <div class="mb-3 mt-3">{{ product.formattedDescription }}</div>

                    <a href="#" @click="contact" class="btn btn-lg btn-primary btn-block mb-3">Contact us about this item</a>
                    <router-link :to="{ name: 'home' }" class="btn btn-secondary btn-sm">&lt; Back to all products</router-link>
                </div>
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
                    this.product.formattedDescription = this.product.description.replace('\n', '<br>')
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
            },
            contact() {
                alert('Pretend this is a contact page or something useful')
            }
        },
        mounted() {
            this.loadProductDetails()
        },
        watch: {
            '$route.params.id': function (id) {
                window.scrollTo(0,0)
                this.id = id
                this.loaded = false
                this.selectedThumbnail = 0
                this.product = null
                this.relatedProducts = []
                this.loadProductDetails()
            }
        }
    }
</script>
