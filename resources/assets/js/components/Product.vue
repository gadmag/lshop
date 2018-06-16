<template>
    <div class="thumbnail">

        <img class="img-responsive"
             :src="imagepath"
             alt="Картинка">

        <a :class="className" @click="toggleWishList? removeToWishList() : addToWishList()"><span class="ico ico-wishlist link-wishlist fa fa-heart"></span></a>
        <div class="caption">
            <h3>{{product.title}}</h3>
            <p class="description">{{product.description}}</p>
            <div class="clearfix"></div>
            <div class="pull-left price">{{product.retail_price}}</div>
            <div class="pull-right add-to-cart"><a @click="addToCart" class="btn btn-success" role="button">Добавить</a>
            </div>
            <div class="clearfix"></div>

            <div class="product-title"><a :href="productlink">{{product.title}}</a></div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['product', 'addtocart', 'productlink', 'imagepath'],
        data: function (){
            return {
                className: ''
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            addToCart() {
                bus.$emit('added-to-cart', this.product);
            },

            addToWishList() {
                bus.$emit('added-to-wishlist', this.product);
            },

            removeToWishList() {
                bus.$emit('remove-to-wishlist', this.product);
            },

        },

        computed: {
            toggleWishList() {
                // console.log(this.$parent.wishList[this.product.id])
                if(this.$parent.wishList[this.product.id])
                {
                    if ( window.location.pathname.replace('/','') == 'wishlist'){
                        // console.log(this.wishList[product.id].title);
                        // Vue.delete(this.$parent.wishList, this.product.id);
                        // delete this.$parent.wishList[this.product.id];
                        delete this.product;
                    }
                    this.className = 'active';
                    return true;
                }else {
                    this.className = '';
                    return false;
                }
            }
        }
    }
</script>
