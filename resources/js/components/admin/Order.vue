<template>
  <div class="orders-form col-12 table-responsive">
    <table class="table table-valign-middle table-striped table-shopping-cart">
      <thead>
      <tr>
        <th>Наименование товара</th>
        <th>Кол-во:</th>
        <th class="text-right">Цена за шт</th>
        <th class="text-right">Всего</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(item, key) in forms" class="option-value-row">
        <td class="">
          <div class="p-2">
            <a :href="'/storage/files/600x450/'+item.image" class="group1">
              <img v-if="item.image"
                   :src="'/storage/files/90x110/'+item.image"
                   class="img-fluid rounded shadow-sm" width="80" alt="Фото товара">
            </a>
            <div class="ml-3 d-inline-block align-middle">
              <div class="mb-0">
                <span href="#" class="text-dark d-inline-block align-middle">{{ item.name }}</span>
              </div>
              <span v-if="item.options.color" class="text-muted d-block">
                Цвет: {{ item.options.color }}
              </span>
              <span v-if="item.options.color_stone" class="text-muted d-block">
                Цвет камня: {{ item.options.color_stone }}
              </span>

              <div id="engravingCart" v-if="item.engravings && Object.keys(item.engravings).length > 0"
                   class="callout callout-default engraving-list">
                <b>Гравировка:</b>
                <div v-for="(engraving, keyEngraving) in item.engravings" class="text-left d-flex">
                  <div class="dropdown flex-fill text-left">
                    <span class="title">{{ engraving.title }}</span>
                    <span class="font">{{ engraving.font }}</span>
                    <a class="link-file px-1" v-if="engraving.filename" data-toggle="tooltip" title="Файл"
                       target="_blank" :href="'/storage/files/'+engraving.filename"><i class="fa fa-file-alt"></i></a>
                    <a v-if="engraving.text" v-text="`текст`" class="dropdown-toggle px-1" href="#" role="button"
                       id="dropdownText" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <a v-if="engraving.comment" v-text="`комментарий`" class="dropdown-toggle px-1" href="#"
                       role="button" id="dropdownComment" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"></a>
                    <div v-if="engraving.comment" class="dropdown-menu" aria-labelledby="dropdownComment">
                      <span class="dropdown-item-text">{{ engraving.comment }}</span>
                    </div>
                    <div v-if="engraving.text" class="dropdown-menu" aria-labelledby="dropdownText">
                      <span class="dropdown-item-text">{{ engraving.text }}</span>
                    </div>
                  </div>
                  <div class="flex-fill ml-3 text-right">
                    <span class="qty">{{ engraving.qty }}x</span>
                    <span class="price">{{ engraving.price }} р.</span>
                    <span @click="removeEngraving(key,keyEngraving)" title="Удалить"
                          class="text-danger remove-engraving"><i class="fa fa-times"></i></span>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div v-if="item.item.services && item.item.services.length >0" class="text-right add-engraving-cart">
            <button @click="openModal(key,item.item)" type="button" class="btn btn-link" data-toggle="modal"
                    data-target="#engravingModal">
              <i class="fa fa-plus"></i> Добавить гравировку
            </button>
          </div>
        </td>
        <td style="max-width: 60px">
          <div class="input-group input-group-sm">
            <input type="text" class="form-control" v-model="item.quantity = item.qty" name="quantity">
            <span class="input-group-append">
                        <button data-qty="" @click="updateFromCart(key,item.quantity)" type="button"
                                class="btn btn-primary" data-toggle="tooltip"
                                data-original-title="Обновить"><i class="fa fa-sync"></i></button>
                    </span>
          </div>
        </td>
        <td class="text-right">{{ item.price }} р.</td>
        <td class="text-right">{{ item.price * item.qty }} р.</td>
        <td>
          <button v-if="item" :data-id="item.id" @click="removeFromCart(key)" type="button"
                  data-toggle="tooltip"
                  class="remove-options btn btn-sm btn-danger"><i
              class="fa fa-minus-circle"></i></button>
        </td>
      </tr>
      </tbody>
    </table>

    <div class="row">
      <div class="col-md-6 col-md-offset-6">
        <div class="row form-field">
          <div class="col-md-6 text-right"><b>Предварительная стоимость:</b></div>
          <div class="col-md-6 text-left"><b>{{ cart.totalPrice }} р.</b></div>
        </div>
        <div v-if="cart.shipment" class="row">
          <div class="col-md-6">
            <select class="form-control" v-model="shipment_id" name="shipment_method"
                    @change="addShipmentToCart" id="shipment_method">
              <option :value="null">Выбрать</option>
              <option :selected="shipment_id == shipment.id"
                      v-for="(shipment, key) in shipments" :value="shipment.id">
                {{ shipment.title }}
              </option>
            </select>
          </div>
          <div class="col-md-6">
            <div class="input-group">
              <input class="form-control" name="shipment_price" v-model="shipment_price" type="number">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-ruble-sign"></i></span>
              </div>
            </div>
          </div>

        </div>

        <div v-if="cart.coupons" v-for="coupon in cart.coupons" class="row form-field">
          <div class="col-md-6 text-right"><strong>Промокод: {{ coupon.name }}</strong></div>
          <div v-if="coupon.discount" class="col-md-6"><strong>- {{ coupon.discount }} р</strong></div>
        </div>

        <div class="row form-field">
          <div class="col-md-6 text-right pt-1"><b>Итоговая сумма:</b></div>
          <div class="col-md-6">
            <div class="input-group">
              <input name="totalPrice" v-model="totalPrice" class="form-control" type="text">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-ruble-sign"></i></span>
              </div>
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
            <div><span class="help-block">{{ error_coupon }}</span></div>
          </div>
        </div>
      </div>
      <br>
    </fieldset>
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Добавить товары</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="keywords">Выбрать товар</label>
          <div class="dropdown">
            <input id="keywords" autocomplete="off" type="text" @focus="onFocus" @blur="onBlur"
                   v-model="keywords" class="form-control">
            <ul class="dropdown-menu" :class="{active: toggled }" v-if="results && results.length > 0">
              <li class="dropdown-item" v-for="product in results" :key="product.id"><a href="#"
                                                                                        @mousedown="selectProduct(product)"
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
        <div class="form-group text-right">
          <button :disabled="!product" id="add-product" @click="addToCart(product.id)" data-type="coating"
                  type="button" data-toggle="tooltip" class="btn btn-primary">
            <i class="fa fa-plus-circle"></i> Добавить продукт
          </button>
        </div>
      </div>
    </div>

    <engraving name="order" :fonts="fonts" @getCart="updateCart($event)" :order_id="order.id" :cart-key="cartKey"
               :services="services"></engraving>

  </div>
</template>

<script>
import SelectOption from '../SelectOption'
import Engraving from "../Engraving";

export default {
  props: {
    order: {
      type: Object,
      default: []
    },
    shipments: {},
    products: null,
    coupons: null,
    fonts: '',
    payment_config: null

  },
  components: {
    'select-option': SelectOption,
    'engraving': Engraving,
  },
  data() {
    return {
      cart: this.order.cart,
      forms: null,
      shipment_price: this.order.cart.shipment.price,
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
      services: '',
      cartKey: '',
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
      // this.shipment_price = this.cart.shipmentPrice;
    },

    // shipment_price() {
    //   let coupon_price = _.sumBy(this.cart.coupons, (item) => item.discount);
    //   this.totalPrice = parseFloat(this.cart.totalPrice) + parseFloat(this.shipment_price) - parseFloat(coupon_price);
    // },

  },

  methods: {

    addCouponToCart() {
      const url = '/api/add-coupon/' + this.coupon_code;
      this.fetchCart(url, {order_id: this.order.id})
    },

    addShipmentToCart() {
      const url = '/api/add-shipment/' + this.shipment_id;
      console.log('addShipmentToCart')
      // this.fetchCart(url, {
      //   order_id: this.order.id,
      //   price: this.shipment_price
      // });
    },

    addShipmentPriceToCart(){

    },


    addToCart(id) {
      let url = '/api/add-to-cart/' + id;
      this.fetchCart(url, {options: JSON.stringify(this.query_options), order_id: this.order.id});
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

    removeEngraving(keyCartItem, keyEngraving) {
      let params = {options: JSON.stringify({keyCartItem, keyEngraving}), order_id: this.order.id};
      axios.get('/api/remove-engraving', {params: params})
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

    openModal(key, item) {
      this.cartKey = key;
      this.services = item.services;

    },

    selectOption(option) {
      let id = option.id;
      this.query_options.id = id;
    },

    updateCart(cart) {
      this.cart = cart;
      this.forms = cart.content;
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
