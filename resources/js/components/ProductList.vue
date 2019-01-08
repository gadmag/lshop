<template>
    <div class="product-item">
        <div class="thumbnail">
            <img class="img-responsive"
                 :src="imagepath"
                 alt="Картинка">
            <span v-if="persentprice" class="special-badge">-{{persentprice}}%</span>
            <a :class="" @click="toggleWishList? removeToWishList(product.id) : addToWishList(product.id)"><span
                    :class="toggleWishList? className: className"></span></a>
            <div class="caption">
                <div class="product-name text-center"><a class="" :href="productlink">{{product.title}}</a></div>
                <div class="product-price text-center"><span class="special" v-if="pricespecial">{{pricespecial}} р.</span> <span>{{price}} р.</span>
                </div>
                <div class="product-link text-center"><a class="button action primary" :href="productlink">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product', 'price', 'productlink', 'imagepath', 'pricespecial', 'persentprice'],
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

        },

        computed: {
            toggleWishList() {

                // console.log(this.$parent.wishList[this.product.id])
                if (this.$parent.wishList[this.product.id]) {
                    if (window.location.pathname.replace('/', '') == 'wishlist') {
                        // console.log(this.wishList[product.id].title);
                        // Vue.delete(this.$parent.wishList, this.product.id);
                        // delete this.$parent.wishList[this.product.id];
                        delete this.product;
                    }

                    this.className = 'ico ico-wishlist link-wishlist fa fa-heart';
                    return true;
                } else {
                    this.className = 'ico ico-wishlist link-wishlist fa fa-heart-o';
                    return false;
                }
            }
        }
    }
</script>
