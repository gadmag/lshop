<template>
    <div>
        <filterable v-bind="filterable">
            <div class="col-md-4" slot-scope="{item}">
                <div class="product-item">
                    <div class="thumbnail">
                        <img v-if="item.files && item.files.length" class="img-responsive"
                             :src="'/storage/files/250x250/'+item.files[0].filename"
                             alt="Картинка">

                        <!--<img v-else-if="item.product_options && item.product_options.length" class="img-responsive"-->
                             <!--:src="'/storage/files/250x250/'+item.product_options.files.filename"-->
                             <!--alt="Картинка">-->
                        <span v-if="item.product_special" class="special-badge"> -{{specialPrice(item)}}%</span>
                        <a :class=""
                           @click="toggleWishList(item.id)? removeToWishList(item.id) : addToWishList(item.id)"><span
                                :class="toggleWishList? className: className"></span></a>
                        <div class="caption">
                            <div class="product-name text-center"><a class="" :href="'/products/'+item.alias">{{item.title}}</a>
                            </div>
                            <div class="product-price text-center"><span class="special" v-if="item.product_special">{{Number(item.product_special.price).toFixed(0)}} р.</span>
                                <span>{{Number(item.price).toFixed(0)}} р.</span></div>
                            <div class="product-link text-center"><a class="button action primary" :href="'/products/'+item.alias">Подробнее</a>
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
        props: ['filters'],
        data() {
            return {
                className: '',
                filterable: {
                    url: 'api/products',
                    orderables: [
                        {title: 'Дата (старые)', options: {name: 'created_at', direction: 'asc'}},
                        {title: 'Дата (новые)', options: {name: 'created_at', direction: 'desc'}},
                        {title: 'Цена (убывание)', options: {name: 'price', direction: 'desc'}},
                        {title: 'Цена (возрастание)', options: {name: 'price', direction: 'asc'}},
                        {title: 'Имя (Я - А)', options: {name: 'title', direction: 'desc'}},
                        {title: 'Имя (А - Я)', options: {name: 'title', direction: 'asc'}},
                    ],
                    filterGroups: [
                            {title: 'Материал', name: 'material', item: this.filters.material},
                            {title: 'Покрытие', name: 'coating', item: this.filters.coating},
                            {title: 'Цвет', name: 'productOptions.color', item: this.filters.color},
                        ],
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

            specialPrice(item) {

                return Math.floor(((item.price - item.product_special.price) / item.price) * 100);
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
