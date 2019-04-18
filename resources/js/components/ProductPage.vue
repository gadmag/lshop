<template>
    <div class="row">
        <div class="col-sm-6">
            <ul class="list-unstyled" v-if="files" id="thumbnails">
                <li class="image-product-item" v-for="(image, key, index) in files">
                    <a class="group2" v-if="key == 0" :href="'/storage/files/'+ image.filename"><img
                            class="img-fluid" :src="'/storage/files/600x450/'+ image.filename" alt="Фото продукта"></a>
                    <a class="group2 thumbnail" v-else :href="'/storage/files/'+ image.filename"><img
                            :src="'/storage/files/90x110/'+ image.filename" alt="Фото продукта"></a>
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
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Описание</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Характеристики</a></li>

                </ul>

                <div class="tab-content">
                    <div id="home" v-html="product.description" class="tab-pane fade show active"></div>
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
                <h2><span v-bind:class="{'through': isSpecial}" class="price">{{getPrice}} р.</span></h2>
                <h2 v-if="special"><span class="special-price">{{getSpecialPrice}} </span><span>р.</span></h2>
                <!--<h2>{{getPrice}}</h2>-->
            </div>


            <div v-if="discount" class="discount-block">
                <hr>
                <span>{{discount.quantity}} и более {{getDiscountPrice}} р.</span>
                <hr>
            </div>
            <div v-if="options" class="options-block">
                <div v-if="options && options.length > 0" class="form-group">
                    <label for="options_color">Цвет </label>
                    <select class="form-control" name="options_color" v-model="query_options.option_id"
                            id="options_color">
                        <option :selected="null" v-bind:value="null">Выбрать</option>
                        <option :disabled="option.quantity <= 0" v-for="option in options" :value="option.id">
                            {{fullOptionName(option)}}
                        </option>
                    </select>
                </div>
                <div class="quantity form-group">
                    <label for="quantity">Кол-во</label>
                    <input type="number" v-model="query_options.quantity" name="quantity" id="quantity"
                           class="form-control" :max="product.quantity">
                </div>
                <div class="button-block clearfix">
                            <button :disabled="product.quantity <= 0" class="mb-2 lotus-button btn"
                                    @click="addToCart(product.id)">Добавить в корзину
                            </button>

                            <button class="mb-2 lotus-button btn"
                                    @click="toggleWishList? removeToWishList(product.id) : addToWishList(product.id)">
                                Добавить
                                в избранное
                            </button>
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
            this.allImagesProduct();
            console.log('Component mounted.');

        },
        methods: {

            getOptionByID(id) {
                let option = false;
                this.options.forEach(function (item, i) {
                    if (id === item.id) {
                        option = item;
                    }
                });
                return option;
            },
            addOptionPrice(price, discount_price = 0) {
                let id = this.query_options.option_id;
                if (id !== null) {
                    let option = this.getOptionByID(id);
                     let total_price = parseFloat(option.price) - parseFloat(discount_price) ;
                    return total_price.toFixed(2);
                }
                let total_price = (price - discount_price)
                return total_price.toFixed(2);
            },

            fullOptionName(option) {
                let optionFullName = '';
                if (option.color) {
                    optionFullName = "Цвет: " + option.color
                }
                if (option.color_stone) {
                    let separator = optionFullName ? optionFullName + '/' : '';
                    optionFullName = separator + "Цвет камня: " + option.color_stone
                }
                return optionFullName
            },

            allImagesProduct() {
                let _this = this;
                this.files = this.images ? this.images : [];
                this.options.forEach(function (item, i) {
                    if (item.files != undefined && item.files != null) {
                        _this.files.push(item.files);
                    }
                });

                return this.files;
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

            getPrice() {
                return this.addOptionPrice(this.product.price);
            },

            getDiscountPrice() {
                return this.addOptionPrice(this.product.price, this.discount.price);
            },

            getSpecialPrice() {
                return this.addOptionPrice(this.product.price, this.special.price);
            },

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


        }
    }
</script>
