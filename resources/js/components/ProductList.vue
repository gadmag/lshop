<template>
    <div class="row">
    <template v-for="(product, key) in products">
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="product-item mb-3 card">
            <img v-if="product.files && product.files.length" class="card-img-top img-fluid"
                 :src="'/storage/files/250x250/'+product.files[0].filename"
                 alt="Картинка">
            <span v-if="product.product_special" class="special-badge"> -{{specialPrice(product)}}%</span>
            <a @click="toggleWishList(product.id)? removeToWishList(product.id) : addToWishList(product.id)"><span
                    :class="toggleWishList(product.id)? className: className"></span></a>
            <div class="card-body">
                <div class="product-name text-center"><a class="" :href="'/products/'+product.alias">{{product.title}}</a>
                </div>
                <div class="product-price text-center"><span class="special" v-if="product.product_special">{{Number(product.product_special.price).toFixed(0)}} р.</span>
                    <span>{{Number(product.price).toFixed(0)}} р.</span></div>
                <div class="product-link text-center"><a class="text-uppercase btn btn-outline-dark"
                                                         :href="'/products/'+product.alias">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
    <div v-if="(key+1) % 4 == 0" class="w-100 d-none d-lg-block"></div>
    <div v-if="(key+1) % 2 == 0" class="w-100 d-none d-sm-block d-lg-none"></div>
    </template>
    </div>
</template>

<script>
    export default {
        props: ['products'],
        data: function () {
            return {
                className: '',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            addToCart() {
                bus.$emit('added-to-cart', this.product);
            },

            addToWishList(id) {
                bus.$emit('added-to-wishlist', id);
            },

            removeToWishList(id) {
                bus.$emit('remove-to-wishlist', id);
            },

            specialPrice(item) {
                return Math.floor(((item.price - item.product_special.price) / item.price) * 100);
            },

            toggleWishList(id) {

                // console.log(this.$parent.wishList[this.product.id])
                if (this.$parent.wishList[id]) {
                    if (window.location.pathname.replace('/', '') == 'wishlist') {
                        // console.log(this.wishList[product.id].title);
                        // Vue.delete(this.$parent.wishList, this.product.id);
                        // delete this.$parent.wishList[this.product.id];
                        delete this.product;
                    }

                    this.className = 'ico ico-wishlist link-wishlist fas fa-heart';
                    return true;
                } else {
                    this.className = 'ico ico-wishlist link-wishlist fal fa-heart';
                    return false;
                }
            }
        },

        computed: {
        }
    }
</script>
