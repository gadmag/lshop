<template>
    <div class="orders-form">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td>Наименование товара &nbsp;&nbsp;</td>
                <td>Кол-во: &nbsp;&nbsp;</td>
                <th class="text-right">Цена за шт</th>
                <th class="text-right">Всего</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="forms && forms.length > 0" v-for="(item, key) in forms" class="option-value-row">
                <td>
                    <!--                    <input type="hidden" :name="'productOptions['+key+'][id]'" :value="item.product_id">-->
                    {{item.item['title']}}
                </td>
                <td style="max-width: 60px">
                    <div class="input-group">
                        <input type="text" class="form-control" v-model="item.quantity = item['qty']" name="quantity">
                        <span class="input-group-btn">
                        <button data-qty="" @click="updateFromCart(item,item.quantity)" type="button"
                                class="btn btn-primary" data-toggle="tooltip"
                                data-original-title="Обновить"><i class="fa fa-refresh"></i></button>
                    </span>
                    </div>
                </td>
                <td class="text-right">{{item.item.price}} р.</td>
                <td class="text-right">{{item['price']}} р.</td>
                <td>

                    <button v-if="item" :data-id="item.item.id" @click="removeFromCart(key)" type="button"
                            data-toggle="tooltip"
                            class="remove-options btn btn-danger"><i
                            class="fa fa-minus-circle"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-6 col-md-offset-6">
                <div class="row form-field">
                    <div class="col-md-6 text-right"><b>Предварительная стоимость:</b></div>
                    <div class="col-md-6 text-left"><b>{{cart.totalPrice}} р.</b></div>
                </div>
                <div v-if="order.shipment_method" class="row form-field">
                    <div class="col-md-6">
                        <div class="form-inline">
                            <select class="form-control" name="shipment_method" id="shipment_method">
                                <option :value="null">Выбрать</option>
                                <option :selected="order.shipment_method == shipment.method"
                                        v-for="(shipment, key) in payment_config.shipment_method" :value="key">
                                    {{shipment.method}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-inline">
                            <input class="form-control" name="shipment_price" v-model="shipment_price"
                                   type="text">
                            <span> р.</span>
                        </div>
                    </div>

                </div>

                <div class="row form-field">
                    <div class="col-md-6 text-right"><strong>Купон:</strong></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" v-if="coupons" name="coupon" id="">
                                <option :value="null">Выбрать</option>
                                <option v-for="coupon in coupons" :selected="order.coupon == coupon.code"
                                        :value="coupon.code">{{coupon.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row form-field">
                    <div class="col-md-6 text-right"><b>Итоговая сумма:</b></div>
                    <div class="col-md-6">
                        <div class="form-inline">
                            <input name="totalPrice" class="form-control" type="text"
                                   v-model="totalPrice">
                            <span> р.</span>
                        </div>
                        <!--    <textarea name="cart">{{cart}}</textarea>-->

                        <input name="cart" type="hidden" :value="JSON.stringify(cart)">
                    </div>
                </div>
            </div>
        </div>
        <fieldset>
            <legend>Добавить товары</legend>
            <div class="form-group">
                <label for="keywords">Выбрать товар</label>
                <div class="dropdown">
                    <input id="keywords" autocomplete="off" type="text" @focus="onFocus" @blur="onBlur"
                           v-model="keywords" class="form-control">
                    <ul class="dropdown-menu" :class="{active: toggled }" v-if="results && results.length > 0">
                        <li v-for="product in results" :key="product.id"><a href="#" @mousedown="selectProduct(product)"
                                                                            v-html="highlight(product.title)"></a>
                        </li>
                    </ul>
                </div>
                <input type="hidden" name="product_id">
            </div>
            <div class="form-group">
                <label for="quantity">Кол-во</label>
                <input type="number" v-model="query_options.quantity" name="quantity" id="quantity"
                       class="form-control">
            </div>
            <div v-if="product" class="options">
                <select-option v-if="product && options" :product="product" :options="options"></select-option>
            </div>
        </fieldset>
        <div class="text-right">
            <button :disabled="!product" id="add-product" @click="addToCart(product.id)" data-type="coating"
                    type="button" data-toggle="tooltip"
                    class="option-button btn btn-primary"><i class="fa fa-plus-circle"></i> Добавить продукт
            </button>
        </div>
    </div>
</template>

<script>
    import SelectOption from '../../../js/components/SelectOption'

    export default {
        props: {
            order: {
                type: Object,
                default: []
            },
            products: null,
            coupons: null,
            payment_config: null

        },
        components: {
            'select-option': SelectOption,
        },
        data() {
            return {
                cart: this.order.cart,
                forms: null,
                shipment_price: this.order.shipment_price,
                totalPrice: null,
                keywords: null,
                results: this.products,
                toggled: false,
                product: null,
                options: null,
                query_options: {
                    option_id: null,
                    quantity: 1,
                },
            }
        },

        mounted() {
            this.totalPrice = this.order.totalPrice;
            // this.cart = this.order.cart;
            this.forms = this.cart.items;
            console.log('Component mounted.')
        },

        created() {
            this.$root.$on('select-option', (option) => {
                this.selectOption(option);
            })
        },

        computed: {},
        watch: {
            keywords(after, before) {
                let _this = this;
                this.throttledMethod(_this);
            },
            cart() {
                let value = parseFloat(this.cart.totalPrice) + parseFloat(this.shipment_price);
                this.totalPrice = value.toFixed(2);
            },

            shipment_price() {
                let value = parseFloat(this.cart.totalPrice) + parseFloat(this.shipment_price);
                this.totalPrice = value.toFixed(2);
            }

        },

        methods: {

            fetch() {
                axios.get('/admin/api/orders', {params: {keywords: this.keywords}})
                    .then(response => {
                        this.results = response.data;
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },


            addToCart(id) {
                let params = {options: JSON.stringify(this.query_options), cart: JSON.stringify(this.cart)};
                this.fetchCart('/admin/api/orders/add-to-cart/' + id, params);
            },

            removeFromCart(id) {
                let params = {cart: JSON.stringify(this.cart)}
                this.fetchCart('/admin/api/orders/remove-to-cart/' + id, params);
            },

            updateFromCart(item, quantity) {
                let option = {quantity: quantity, option_id: item['option_id']};
                let params = {cart: JSON.stringify(this.cart), option: JSON.stringify(option)};
                this.fetchCart('/admin/api/orders/update-cart/' + item['product_id'], params);
            },

            fetchCart(url, params) {
                axios.post(url, params)
                    .then(response => {
                        this.cart = JSON.parse(response.data.cart);
                        this.forms = this.cart.items;
                        console.log(this.cart);
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },

            selectProduct(product) {
                this.keywords = product.title;
                this.product = product;
                if (product.product_options && product.product_options.length > 0) {
                    this.options = product.product_options;
                    this.query_options.option_id = this.options[0].id
                } else {
                    this.options = null;
                    this.query_options.option_id = null;
                }
                this.dropdownToggle = false;
            },
            selectOption(option) {
                let id = option.id;
                this.query_options.option_id = id;
            },

            onFocus() {
                this.toggled = !this.toggled;
            },

            onBlur() {
                this.toggled = false;
            },

            highlight(text) {
                return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>');
            },

            throttledMethod: _.debounce((_this) => {
                _this.fetch();
            }, 300)
        }

    }
</script>
