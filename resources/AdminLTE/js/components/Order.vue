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
            <tr v-for="(item, key) in forms" class="option-value-row">
                <td>{{item.name}}</td>
                <td style="max-width: 60px">
                    <div class="input-group">
                        <input type="text" class="form-control" v-model="item.quantity = item.qty" name="quantity">
                        <span class="input-group-btn">
                        <button data-qty="" @click="updateFromCart(key,item.quantity)" type="button"
                                class="btn btn-primary" data-toggle="tooltip"
                                data-original-title="Обновить"><i class="fa fa-refresh"></i></button>
                    </span>
                    </div>
                </td>
                <td class="text-right">{{item.price}} р.</td>
                <td class="text-right">{{item.price * item.qty}} р.</td>
                <td>

                    <button v-if="item" :data-id="item.id" @click="removeFromCart(key)" type="button"
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
                <div v-if="cart.shipment" class="row form-field">
                    <div class="col-md-6">
                        <div class="form-inline">
                            <select class="form-control" v-model="shipment_id" name="shipment_method"
                                    @change="addShipmentToCart" id="shipment_method">
                                <option :value="null">Выбрать</option>
                                <option :selected="shipment_id == shipment.id"
                                        v-for="(shipment, key) in shipments" :value="shipment.id">
                                    {{shipment.title}}
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

                <div v-if="cart.coupons" v-for="coupon in cart.coupons" class="row form-field">
                    <div class="col-md-6 text-right"><strong>Промокод: {{coupon.name}}</strong></div>
                    <div class="col-md-6"><strong>- {{coupon.discount}} р</strong></div>
                </div>

                <div class="row form-field">
                    <div class="col-md-6 text-right"><b>Итоговая сумма:</b></div>
                    <div class="col-md-6">
                        <div class="form-inline">
                            <input name="totalPrice" v-model="totalPrice" class="form-control" type="text">
                            <span> р.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <fieldset>
            <legend>Добавить промокод</legend>
            <div class="row">
                <div class="col-md-4">
                    <div class="coupon-add form-group" :class="{'has-error': error_coupon}">
                        <div class="input-group">
                            <input type="text" placeholder="Промокод" v-model="coupon_code" class="form-control">
                            <span class="input-group-btn">
                            <button class="btn btn-default" @click="addCouponToCart" type="button"><i
                                    class="fa fa-gift"></i>Применить</button>
                        </span>
                        </div>
                        <div><span class="help-block">{{error_coupon}}</span></div>
                    </div>
                </div>
            </div>
            <br>
        </fieldset>
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
            shipments: {},
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
                shipment_price: null,
                subTotal: null,
                totalPrice: null,
                keywords: null,
                results: this.products,
                toggled: false,
                product: null,
                shipment_id: null,
                options: null,
                coupon_code: null,
                error_coupon: null,
                query_options: {
                    id: null,
                    quantity: 1,
                },
            }
        },

        mounted() {
            this.subTotal = this.cart.totalPrice;
            this.totalPrice = this.cart.totalWithCoupons;
            this.forms = this.cart.content;
            this.shipment_price = this.cart.shipment.price;
            this.shipment_id = this.cart.shipment.id;
            console.log('Component mounted.')
        },

        created() {
            this.$root.$on('select-option', (option) => {
                this.selectOption(option);
            })
        },

        watch: {
            keywords(after, before) {
                let _this = this;
                this.throttledMethod(_this);
            },
            cart() {
                this.totalPrice = this.cart.totalWithCoupons;
                this.shipment_price = this.cart.shipment.price;
            },

            shipment_price() {
                let coupon_price = _.sumBy(this.cart.coupons,(item) => item.discount);
                this.totalPrice = parseFloat(this.cart.totalPrice) + parseFloat(this.shipment_price) - parseFloat(coupon_price);
            },

        },

        methods: {

            addCouponToCart() {
                const url = '/api/add-coupon/' + this.coupon_code;
                this.fetchCart(url,{order_id: this.order.id})
            },

            addShipmentToCart() {
                const url = '/api/add-shipment/' + this.shipment_id;
                this.fetchCart(url, {order_id: this.order.id});
            },


            addToCart(id) {
                let url = '/api/add-to-cart/'+id;
                this.fetchCart(url,  {options: JSON.stringify(this.query_options), order_id: this.order.id});
            },

            removeFromCart(uniqueId) {
                const url = '/api/remove/' + uniqueId;
                this.fetchCart(url, {order_id: this.order.id});
            },

            updateFromCart(uniqueId, quantity) {
                const url = '/api/update-cart/' + uniqueId;
                let params = {quantity: quantity, order_id: this.order.id};
                this.fetchCart(url, params);

            },

            fetchCart(url, params) {
                axios.get(url, {params: params})
                    .then((res) => {
                        if (res.data.cart) {
                            this.cart = res.data.cart;
                            this.forms = this.cart.content;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            },

            fetch() {
                axios.get('/admin/api/orders', {params: {keywords: this.keywords}})
                    .then(response => {
                        this.results = response.data;
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
                    this.query_options.id = this.options[0].id
                } else {
                    this.options = null;
                    this.query_options.id = null;
                }
                this.dropdownToggle = false;
            },
            selectOption(option) {
                let id = option.id;
                this.query_options.id = id;
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
