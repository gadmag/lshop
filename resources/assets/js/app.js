/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.bus = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('product', require('./components/Product.vue'));
Vue.component('cart-count', require('./components/CartCount.vue'));
Vue.component('cart-detail', require('./components/CartDetail.vue'));
Vue.component('wish-list', require('./components/WishList.vue'));
Vue.component('wish-count', require('./components/WishListCount.vue'));

const app = new Vue({
    el: '#app',
    data: function () {
        return {
            cart: [],
            itemCount: 0,
            wishList: [],
            wishListCount: 0,
            bool: false
        }
    },

    created() {
        bus.$on('added-to-cart', (product) => {
            this.getCartJson('add-to-cart',product);
        });
        bus.$on('remove-from-cart', (product) => {

            this.getCartJson('reduce', product);
        });
        bus.$on('added-to-wishlist', (product) => {
           this.getWishList('add-to-wishlist',product);
        });

        bus.$on('remove-to-wishlist', (product) => {
            console.log(product);
            this.getWishList('remove-to-wishlist',product);
        });

        this.getCartJson('shopping-cart-detail');
        this.getWishList('wishlist-json');
    },
    methods: {

        handleResponse(data) {
             // console.log(data);
            if (data.cart) {
            this.cart = data.cart;
            this.itemCount = data.cart.totalQty;
            }

        },
        handleResponseWishList(data) {
            // console.log(data.wishList.items);
            if (data.wishList){
                this.wishList = data.wishList.items;
                this.wishListCount = data.wishList.totalQty;
            }



        },
        getCartJson(url, product = '') {
            if (product){
                url = url + '/'+ product.id
            }
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                cache: false,
                success: this.handleResponse,
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status + ' ' + thrownError);
                }
            });
        },

        getWishList(url, product){
            if (product){
                url = url + '/'+ product.id
            }
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                cache: false,
                success: this.handleResponseWishList,
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status + ' ' + thrownError);
                }
            });
        },

    },

    computed: {
    }
});
