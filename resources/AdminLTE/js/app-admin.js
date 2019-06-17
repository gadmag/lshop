/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.bus = new Vue;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('option-item', require('./components/OptionItem.vue'));
Vue.component('order', require('./components/Order.vue'));


const app = new Vue({
    el: '#app-admin',
    data: function () {
        return {


        }
    },

    created() {
        // bus.$on('added-to-cart', (id, options) => {
        //     this.addToCart('/add-to-cart', id, options);
        // });
    },
    methods: {

        // addToCart(url, id,  options) {
        //     axios.get('/add-to-cart/'+id, {params: {options: options}})
        //         .then(response => {
        //             console.log(response.data);
        //         })
        //         .catch(error => {
        //             console.log(error)
        //         });
        // },

    },

    computed: {}
});
