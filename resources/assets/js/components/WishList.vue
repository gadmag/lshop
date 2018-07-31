<template>

    <div class="product-item">
        <div class="thumbnail">
            <img class="img-responsive"
                 :src="imagepath"
                 alt="Картинка">
            <span v-if="persentprice" class="special-badge">-{{persentprice}}%</span>
            <a :class="active" @click="removeToWishList(id)"><span
                    class="ico ico-wishlist link-wishlist fa fa-heart"></span></a>
            <div class="caption">
                <div class="product-name text-center">{{product.title}}</div>
                <div class="product-price text-center"><span class="special" v-if="pricespecial">{{pricespecial}} р.</span> <span>{{price}} р.</span></div>
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
                // listItem, //get data from query
                className: '',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            removeToWishList(item) {
                bus.$emit('remove-to-wishlist', item);
            },

        }
    }
</script>
