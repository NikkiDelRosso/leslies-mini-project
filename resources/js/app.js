require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)
Vue.use(VueRouter)
axios.defaults.baseURL = '/api/'

import App from './components/App'
import Home from './components/Home'
import ProductDetails from './components/ProductDetails'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            props: { title: "Welcome" }
        },
        {
            path: '/product/:id',
            name: 'product',
            component: ProductDetails,
            props: { title: "Product Details" }
        },
    ],
})


import ProductSummary from './components/ProductSummary'
Vue.component('product-summary', ProductSummary)

const app = new Vue({
    router,
    render: h => h(App)
}).$mount("#app")