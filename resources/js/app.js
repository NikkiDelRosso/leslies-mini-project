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
import PageNotFound from './components/PageNotFound'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            props: { title: "Our Products" }
        },
        {
            path: '/product/:id',
            name: 'product',
            component: ProductDetails,
            props: { title: "Product Details" }
        },
        {
            path: '/product',
            redirect: '/'
        },
        {
            path: '*',
            component: PageNotFound
        }
    ],
})


import ProductSummary from './components/ProductSummary'
Vue.component('product-summary', ProductSummary)

const app = new Vue({
    router,
    render: h => h(App)
}).$mount("#app")