<template>
    <div class="row">
        <div class="col-sm-6">
            <ul class="list-unstyled" v-if="getConcateImages" id="thumbnails">
                <li class="image-product-item" v-for="(image, key, index) in files">
                    <a class="group2" v-if="key == 0" :href="'/storage/files/'+ image.filename"><img class="img-responsive" :src="'/storage/files/600x450/'+ image.filename" alt="Фото продукта"></a>
                    <a class="group2 thumbnail" v-else :href="'/storage/files/'+ image.filename"><img  :src="'/storage/files/90x110/'+ image.filename" alt="Фото продукта"></a>
                </li>
            </ul>
            <div class="clearfix"></div>
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
                        <p v-if="product.color"><strong>Покрытие:</strong> <span>{{product.color}}</span></p>
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

                <div v-if="options && options.length > 0" class="form-group">
                    <label for="options_color">Цвет </label>
                    <select class="form-control" name="options_color" v-model="query_options.option_id"
                            id="options_color">
                        <option :selected="null" v-bind:value="null">Выбрать</option>
                        <option :disabled="option.quantity <= 0" v-for="option in options" :value="option.id">
                            {{option.color}}
                        </option>
                    </select>
                </div>
                <div class="quantity form-group">
                    <label for="quantity">Кол-во</label>
                    <input type="number" v-model="query_options.quantity" name="quantity" id="quantity"
                           class="form-control" :max="product.quantity">
                </div>
                <div class="button-block clearfix">
                    <ul class=" list-inline">
                        <li>
                            <button :disabled="product.quantity <= 0" class="lotus-button btn"
                                    @click="addToCart(product.id)">Добавить в корзину
                            </button>
                        </li>
                        <li>
                            <button class="lotus-button btn"
                                    @click="toggleWishList? removeToWishList(product.id) : addToWishList(product.id)">
                                Добавить
                                в избранное
                            </button>
                        </li>
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
                files: [],
                checkedNames: [],
                query_options: {
                    option_id: null,
                    quantity: 1,
                },
            }
        },
        mounted() {
            console.log('Component mounted.');

        },
        methods: {
            selectOption(e){
                console.log(e.target.value);
                this.query_options.option_id.push(e.target.value);
            },

            addToCart(id) {
                bus.$emit('added-to-cart', id, this.query_options);
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
                if (this.$parent.wishList[this.product.id]) {
                    if (window.location.pathname.replace('/', '') == 'wishlist') {
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
            },

            getConcateImages() {
                if (this.images)
                {
                    this.files = this.images
                }
                if (this.options) {
                    for (var key in this.options) {
                        if (this.options[key].files !== undefined && this.options[key].files !== null) {
                            this.files.push(this.options[key].files)
                        }
                    }
                }

                return this.files;
            }

        }
    }
</script>
