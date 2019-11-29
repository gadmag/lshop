<template>
    <div class="list-product">
        <filterable v-bind="filterable">
            <template slot-scope="{item, key}">
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="product-item mb-3  card">
                        <img class="card-img-top img-fluid"
                             :src="'/storage/files/250x250/'+getImage(item)"
                             alt="Картинка">

                        <span v-if="item.product_special && item.product_options[0]" class="special-badge"> -{{specialPrice(item)}}%</span>
                        <a :class=""
                           @click="toggleWishList(item.id)? removeToWishList(item.id) : addToWishList(item.id)"><span
                                :class="toggleWishList(item.id)? className: className"></span></a>
                        <div class="card-body">
                            <div class="product-name text-center"><a class="" :href="'/products/'+item.alias">{{item.title}}</a>
                            </div>
                            <div class="product-price text-center">
                                <span class="special" v-if="item.product_special">{{Number(item.product_special.price).toFixed(0)}} р.</span>
                                <span v-if="item.type == 'service'">{{Number(item.price)}} р.</span>
                                <span v-else-if="item.product_options[0]">{{Number(item.product_options[0].price).toFixed(0)}} р.</span>
                            </div>
                            <div class="product-link text-center"><a class="text-uppercase btn btn-outline-dark"
                                                                     :href="'/products/'+item.alias">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="(key+1) % 3 == 0" class="w-100 d-none d-lg-block"></div>
                <div v-if="(key+1) % 2 == 0" class="w-100 d-none d-sm-block d-lg-none"></div>
            </template>
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
                    url: '/api/products',
                    orderables: [
                        {title: 'Дата (новые)', options: {name: 'created_at', direction: 'desc'}},
                        {title: 'Дата (старые)', options: {name: 'created_at', direction: 'asc'}},
                        {title: 'Цена (убывание)', options: {name: 'price', direction: 'desc'}},
                        {title: 'Цена (возрастание)', options: {name: 'price', direction: 'asc'}},
                        {title: 'Имя (Я - А)', options: {name: 'title', direction: 'desc'}},
                        {title: 'Имя (А - Я)', options: {name: 'title', direction: 'asc'}},
                    ],
                    filterGroups: [
                        {title: 'Стоимость', name: 'price', field: 'productOptions.price', collapsed: true},
                        {
                            title: 'Материал',
                            name: 'material',
                            field: 'material',
                            collapsed: true,
                            item: this.filters.material
                        },
                        {title: 'Категории', name: 'categories', field: 'catalogs.name', item: this.filters.categories},
                        {
                            title: 'Цвет покрытия',
                            name: 'coating',
                            field: 'productOptions.color',
                            item: this.filters.coating
                        },
                        {
                            title: 'Цвет камня',
                            name: 'stone',
                            field: 'productOptions.color_stone',
                            item: this.filters.stone
                        },
                    ],
                    paginateItemLimits: [12, 24, 50]
                }
            }
        },
        mounted() {
            console.log('Component ProductList2 mounted.')
        },
        methods: {
            toggleWishList(id) {

                if (this.$parent.wishList[id]) {

                    this.className = 'ico ico-wishlist link-wishlist fas fa-heart';
                    return true;
                } else {
                    this.className = 'ico ico-wishlist link-wishlist fal fa-heart';
                    return false;
                }
            },

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
                return Math.floor(((item.product_options[0].price - item.product_special.price) / item.product_options[0].price) * 100);
            },

            getImage(product) {
                let filename = '';
                let options = product.product_options;
                if (product.files && product.files.length) {
                    return product.files[0].filename;
                }
                if (!options) {
                    return ''
                }
                for (let i = 0; i < options.length; i++) {
                    if (options[i].files && options[i].files.length) {
                        return options[i].files[0].filename;
                    }
                }

                return '';
            }

        },

    }
</script>
