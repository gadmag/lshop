<template>
    <div>
        <filterable v-bind="filterable">
            <div class="col-md-4" slot-scope="{item}">
                <div class="product-item">
                    <div class="thumbnail">

                        <img v-if="item.files && item.files.length" class="img-responsive"
                             :src="'/storage/files/250x250/'+item.files[0].filename"
                             alt="Картинка">
                        <span v-if="item.product_special" class="special-badge"> -{{specialPrice(item)}}%</span>
                        <a :class="" @click="toggleWishList(item.id)? removeToWishList(item.id) : addToWishList(item.id)"><span
                                :class="toggleWishList? className: className"></span></a>
                        <div class="caption">
                            <div class="product-name text-center"><a class="" :href="item.alias">{{item.title}}</a></div>
                            <div class="product-price text-center"><span class="special" v-if="item.product_special">{{item.product_special.price}} р.</span>
                                <span>{{item.price}} р.</span></div>
                            <div class="product-link text-center"><a class="button action primary" :href="item.alias">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </filterable>
    </div>
</template>

<script>
    export default {
        props: ['product', 'price', 'productlink', 'imagepath', 'pricespecial', 'persentprice'],
        data() {
            return {
                className: '',
                filterable: {
                    url: 'api/products'
                }
            }
        },
        mounted() {
            console.log('Component ProductList2 mounted.')
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

            specialPrice(item){

                return Math.floor(((item.price - item.product_special.price)/item.price)*100);
            }

        },

        computed: {
            toggleWishList(id) {

                // console.log(this.$parent.wishList[this.product.id])
                if (this.$parent.wishList[id]) {
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
            },

        }
    }
</script>
