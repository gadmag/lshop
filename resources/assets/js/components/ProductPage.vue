<template>
    <div class="row">
        <div class="col-sm-6">
            <ul v-if="images" id="light-slider">
                <li v-for="image in images" class="text-center" :data-thumb="'/storage/files/90x110/'+ image.filename">
                    <img class="img-responsive" :src="'/storage/files/600x450/' + image.filename"/>
                </li>
            </ul>
        </div>
        <div class="col-sm-6">
            <h1 class="page-title">{{product.title}}</h1>

            <div class="sku-block clearfix">
                <strong>Артикул:</strong> <span>{{product.sku}}</span>
            </div>
            <div class="description-block">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Описание</a></li>
                    <li><a data-toggle="tab" href="#menu1">Характеристики</a></li>

                </ul>

                <div class="tab-content">
                    <div id="home" v-html="product.description" class="tab-pane fade in active">

                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <p v-if="product.model"><strong>Модель:</strong> <span>{{product.model}}</span></p>
                        <p v-if="product.material"><strong>Материал:</strong> <span>{{product.material}}</span></p>
                        <p v-if="product.coating"><strong>Покрытие:</strong> <span>{{product.coating}}</span></p>
                        <p v-if="product.size"><strong>Размер:</strong> <span>{{product.size}}</span></p>
                        <p v-if="product.weight"><strong>Вес:</strong> <span>{{product.weight}}</span></p>
                    </div>

                </div>
            </div>
            <div class="price-block">
                <h2><span v-bind:class="{'through': isSpecial}" class="price">{{product.price}} р.</span></h2>
                <h2 v-if="special"><span class="special-price">{{special.price}} </span><span>р.</span></h2>
            </div>


            <div v-if="discount" class="discount-block">
                <hr>
                <span>{{discount.quantity}} и более {{discount.price}} р.</span>
                <hr>
            </div>


            <div v-if="options" class="options-block">
                <!--<h4>Доступные опции</h4>-->

                    <!--<input v-model="optionAddToCart.product_id" type="hidden" name="product_id">-->
                <!--<div>{{options}}</div>-->
                    <div id="options"  v-if="options.length > 0" class="form-group">
                        <label for="options_color">Цвет</label>
                        <select class="form-control" name="options_color" v-model="optionAddToCart.color" id="options_color">
                            <option :selected="null" v-bind:value="null">Выбрать</option>
                            <option :disabled="option.quantity <= 0" v-for="option in options" :value="option.id">{{option.color}}</option>
                        </select>
                    </div>
                    <div class="quantity form-group">
                        <label for="quantity">Кол-во</label>
                        <input type="number" v-model="optionAddToCart.quantity" name="quantity" id="quantity"
                               class="form-control"  :max="product.quantity">
                    </div>
                    <div class="button-block clearfix">
                        <ul class=" list-inline">
                            <li><button :disabled="product.quantity <= 0" class="lotus-button btn" @click="addToCart(product.id)">Добавить в корзину</button></li>
                            <li><button class="lotus-button btn" @click="toggleWishList? removeToWishList(product.id) : addToWishList(product.id)">Добавить
                                в избранное</button></li>
                        </ul>
                    </div>


                <hr>
                <div class="share-block clearfix">
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,twitter"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product', 'action', 'images', 'options', 'special', 'discount'],
        data: function () {
            return {
                className: '',
                optionAddToCart: {
                   // product_id: this.product.id,
                    color: null,
                    quantity: 1,
                },
                // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            addToCart(id) {
                bus.$emit('added-to-cart', id, this.optionAddToCart);
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
            },

            isSpecial() {
                if (this.special) {
                    return true;
                }
                return false
            }
        }
    }
</script>
