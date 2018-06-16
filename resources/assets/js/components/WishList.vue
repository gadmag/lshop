<template>
    <div>
        <div class="col-sm-6 col-md-4" v-for="item in product">
            <div class="thumbnail">

                <a :class="active" @click="removeToWishList()"><span class="ico ico-wishlist link-wishlist fa fa-heart"></span></a>
                <div class="caption">
                    <div><a href="/product/item.id">{{item.title}}</a></div>

                    <div>{{item.description}}</div>
                    <div class="clearfix"></div>
                    <div class="pull-left price">{{item.retail_price}}</div>
                    <div class="pull-right add-to-cart"><a @click="" class="btn btn-success" role="button">Добавить</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!--<div class="product-title"><a :href="">{{item.title}}</a></div>-->
                <!--<p class="description">{{item.description}}</p>-->
                <!--<div class="clearfix"></div>-->
                <!--<div class="pull-left price">{{item.retail_price}}</div>-->
                <!--<div class="pull-right add-to-cart"><a @click="" class="btn btn-success" role="button">Добавить</a>-->
                <!--</div>-->
                <!--<div class="clearfix"></div>-->

                <!--<div class="product-title"><a :href="">{{item.title}}</a></div>-->
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['product'],
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
            removeToWishList() {
                console.log(this.product);
                // bus.$emit('remove-to-wishlist', this.item);
            },

        },

        computed: {
        }
    }
</script>
