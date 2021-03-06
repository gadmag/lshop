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

Vue.component('option-item', require('./components/admin/OptionItem.vue'));
Vue.component('shipment-field', require('./components/admin/ShipmentField'));
Vue.component('order', require('./components/admin/Order.vue'));
Vue.component('nestable', require('./components/admin/Nestable'));
Vue.component('image-upload', require('./components/upload/ImageUpload.vue'));


const app = new Vue({
    el: '#app-admin',
    data: function () {
        return {
        }
    },

    created() {

    },
    methods: {

    },

    computed: {}
});
