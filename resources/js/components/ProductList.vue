<template>
    <div class="row">
        <template v-for="(item, key) in products">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-item mb-3 card">
                    <img class="card-img-top img-fluid"
                         :src="'/storage/files/250x250/'+getImage(item)"
                         alt="Картинка">
                    <span v-if="item.product_special" class="special-badge"> -{{percentSpecial(item)}}%</span>
                    <a @click="toggleWishList(item.id)? removeToWishList(item.id) : addToWishList(item.id)">
                        <span :class="toggleWishList(item.id)? className: className"></span>
                    </a>
                    <div class="card-body">
                        <div class="product-name text-center">
                            <a class="" :href="'/products/'+item.alias">{{item.title}}</a>
                        </div>
                        <div class="product-price text-center">
                            <span class="special" v-if="item.product_special">{{priceSpecial(item)}} р.</span>
                            <span v-if="item.type == 'service'">{{Number(item.price)}} р.</span>
                            <span v-else-if="item.product_options[0]">{{Number(item.product_options[0].price).toFixed(0)}} р.</span>
                        </div>
                        <div class="product-link text-center"><a class="text-uppercase btn btn-outline-dark"
                                                                 :href="'/products/'+item.alias">Подробнее</a>
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
                image: []
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
                let wishList = this.$parent.wishList;
                let key = _.findKey(wishList, item => item.id == id );
                bus.$emit('remove-to-wishlist', key);
            },

            percentSpecial(item) {
                let price = item.product_options[0] ? item.product_options[0].price : item.price;
                return Math.floor(item.product_special.price / price * 100);
            },

            priceSpecial(item) {
                let price = item.product_options[0] ? item.product_options[0].price : item.price;
                let specialPrice = price - item.product_special.price
                return specialPrice.toFixed(0);
            },

            toggleWishList(id) {
                let wishList = this.$parent.wishList;
                // console.log()
                if (_.find(wishList, item => item.id == id)) {
                    this.className = 'ico ico-wishlist link-wishlist fas fa-heart';
                    return true;
                } else {
                    this.className = 'ico ico-wishlist link-wishlist fal fa-heart';
                    return false;
                }
            },
            getImage(product) {
                let options = product.product_options;
                if (product.files && product.files.length) {
                    return product.files[0].name;
                }
                if (!options) {
                    return ''
                }
                for (let i = 0; i < options.length; i++) {
                    if (options[i].files && options[i].files.length) {
                        return options[i].files[0].name;
                    }
                }

                return ''
            }
        },

        computed: {}
    }
</script>
