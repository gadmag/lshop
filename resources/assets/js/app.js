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
Vue.component('product-list', require('./components/ProductList.vue'));
Vue.component('product-page', require('./components/ProductPage.vue'));
Vue.component('cart-count', require('./components/CartCount.vue'));
Vue.component('cart-detail', require('./components/CartDetail.vue'));
Vue.component('shopping-cart', require('./components/ShoppingCart.vue'));
Vue.component('checkout', require('./components/Checkout.vue'));
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
            bool: false,

        }
    },

    created() {
        bus.$on('added-to-cart', (id, options) => {
            this.addToCart('/add-to-cart', id, options);
        });
        bus.$on('reduce-from-cart', (id) => {
            this.getCartJson('/reduce', id);
        });
        bus.$on('remove-from-cart', (id) => {
            this.getCartJson('/remove', id);
        });
        bus.$on('added-to-wishlist', (id) => {
            this.getWishList('/add-to-wishlist', id);
        });

        bus.$on('remove-to-wishlist', (id) => {
            this.getWishList('/remove-to-wishlist', id);
        });

        this.getCartJson('/shopping-cart-detail');
        this.getWishList('/wishlist-json');
    },
    methods: {

        ajaxGet(url) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                cache: false,
                success: this.handleResponse,
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status + ' ' + thrownError);
                }
            });
        },

        ajaxPost(url, optionAddToCart) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    optionAddToCart: optionAddToCart
                },
                dataType: 'json',
                cache: false,
                success: this.handleResponse,
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status + ' ' + thrownError);
                }
            });
        },

        handleResponse(data) {
            if (data.cart) {
                this.cart = data.cart;
                this.itemCount = data.cart.totalQty;
            }

        },
        handleResponseWishList(data) {
            if (data.wishList) {
                this.wishList = data.wishList.items;
                this.wishListCount = data.wishList.totalQty;
            }


        },
        getCartJson(url, id = null) {
            if (id !== null) {
                url = url + '/' + id;
            }
            this.ajaxGet(url);
        },

        addToCart(url, id,  options) {
            if (id) {
                url = url + '/' + id + '?options='+ JSON.stringify(options);
            }
            this.ajaxGet(url);
        },

        getWishList(url, id) {
            if (id) {
                url = url + '/' + id
            }
            $.ajax({
                type: "GET",
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

    computed: {}
});
