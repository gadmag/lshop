<template>
  <div id="checkout-block">
    <div class="row">
      <div class="col-sm-8">
        <form :action="route" method="post" id="checkoutForm" :class="{'was-validated1': error_toggle}"
              name="checkoutForm">

          <form-wizard @on-complete="onComplete" shape="square"
                       step-size="xs"
                       color="#072d45"
                       title=""
                       subtitle=""
                       back-button-text="Назад"
                       next-button-text="Продолжить"
                       finish-button-text="Купить">
            <tab-content title="Личные данные" :before-change="stepFirstValid">
              <fieldset>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group required">
                      <input :type="text" id="first_name" placeholder="Имя*" name="first_name"
                             v-model="first_name"
                             class="form-control"
                             :class="{'is-invalid': errors && errors.first_name}">
                      <span v-if="errors && errors.first_name" class="invalid-feedback"
                            role="alert">{{ errors.first_name }}</span>

                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group required">
                      <input :type="text" id="last_name" placeholder="Фамилия*" name="last_name"
                             v-model="last_name"
                             class="form-control"
                             :class="{'is-invalid': errors && errors.last_name }">
                      <span v-if="errors && errors.last_name" class="invalid-feedback"
                            role="alert">{{ errors.last_name }}</span>
                    </div>
                  </div>
                </div>


                <div class="form-group required">
                  <input :type="text" id="email" placeholder="E-mail*" name="email" v-model="email"
                         class="form-control" :class="{'is-invalid': errors && errors.email}">
                  <span v-if="errors && errors.email" class="invalid-feedback" role="alert">{{ errors.email }}</span>
                </div>

                <div class="form-group required">
                  <input :type="text" id="telephone" placeholder="Телефон*" name="telephone"
                         v-model="telephone"
                         class="form-control" :class="{'is-invalid': errors && errors.telephone }">
                  <span v-if="errors && errors.telephone" class="invalid-feedback"
                        role="alert">{{ errors.telephone }}</span>
                </div>
                <div class="form-group">
                  <input :type="text" id="company" placeholder="Компания" name="company"
                         v-model="company"
                         class="form-control" :class="{'is-invalid': errors && errors.company }">
                  <span v-if="errors && errors.company" class="invalid-feedback"
                        role="alert">{{ errors.company }}</span>
                </div>
              </fieldset>
              <fieldset>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group required">
                      <input :type="text" id="address" placeholder="Адрес*" name="address"
                             class="form-control"
                             v-model="address" :class="{'is-invalid': errors && errors.address }">
                      <span v-if="errors && errors.address" class="invalid-feedback" role="alert">{{
                          errors.address
                        }}</span>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <input :type="text" id="postcode" placeholder="Индекс" name="postcode"
                             v-model="postcode"
                             class="form-control"
                             :class="{'is-invalid': errors && errors.postcode }">
                      <span v-if="errors && errors.postcode" class="invalid-feedback">{{ errors.postcode }}</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group required">
                      <input :type="text" id="city" placeholder="Город*" name="city" v-model="city"
                             class="form-control" :class="{'is-invalid': errors && errors.city }">
                      <span v-if="errors && errors.city" class="invalid-feedback" role="alert">{{ errors.city }}</span>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group required">
                      <select v-model="country" class="form-control"
                              :class="{'is-invalid': errors && errors.country }">
                        <option :selected="null" :value="null">Выбрать страну*</option>
                        <option v-for="item in countries" :value="item">{{ item.name }}</option>
                      </select>
                      <input id="country" type="hidden" name="country" :value="country_object">
                      <span v-if="errors && errors.country" role="alert" class="invalid-feedback">{{
                          errors.country
                        }}</span>

                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <select name="region" v-model="region" id="region"
                              class="form-control"
                              :class="{'is-invalid': errors && errors.region }">
                        <option :selected="null" v-bind:value="null">Выбрать регион</option>
                        <template v-if="country">
                          <option v-for="region in country.regions" :value="region.name">
                            {{ region.name }}
                          </option>
                        </template>
                      </select>
                      <span v-if="errors && errors.region" class="is-invalid" role="alert">{{ errors.region }}</span>
                    </div>
                  </div>
                </div>
              </fieldset>
            </tab-content>
            <tab-content title="Способ оплаты и доставки" :before-change="stepSecondValid">
              <div class="row">
                <div class="col-xs-12 col-sm-6">
                  <fieldset>
                    <legend>Выберите способ оплаты</legend>
                    <div class="form-group" :class="{'is-invalid': errors && errors.payment }">
                      <div v-for="item in payments" class="custom-control custom-radio">
                        <input :id="item.name" type="radio" name="payment" v-model="payment"
                               :value="JSON.stringify(item)" class="custom-control-input">
                        <label :for="item.name" class="custom-control-label">
                          <img :src="'/storage/files/'+ item.files.name"
                               alt="Банковская карта">{{ item.title }}
                        </label>
                      </div>
                      <span v-if="errors && errors.payment" class="invalid-feedback"
                            role="alert">{{ errors.payment }}</span>
                    </div>
                  </fieldset>
                </div>
                <div class="col-xs-12 col-sm-6">
                  <fieldset>
                    <legend>Выбрать способ доставки</legend>
                    <div class="form-group" :class="{'is-invalid': errors && errors.shipment }">
                      <div v-for="item in shipments" class="custom-control custom-radio">
                        <input :id="item.name" v-model="shipment" type="radio"
                               :value="JSON.stringify(item)"
                               name="shipment" @input="addShipmentToCart(item.id)"
                               class="custom-control-input">
                        <label :for="item.name" class="custom-control-label">
                                                    <span class="img-shipp">
                                                        <img :src="'/storage/files/'+ item.files.name"
                                                             :alt="item.title">
                                                    </span>{{ item.title }}
                        </label>
                      </div>
                      <span v-if="errors && errors.shipment" class="invalid-feedback"
                            role="alert">{{ errors.shipment }}</span>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="row pt-4">
                <div class="col-md-12">
                  <div class="bg-light  px-4 py-3 text-uppercase font-weight-bold">Комментарий к
                    заказу
                  </div>
                  <div class="p-4">
                    <p class="font-italic mb-4">Если у вас есть комментарий к заказу, Вы можете
                      оставить его
                      в поле ниже.</p>
                    <textarea name="comment" id="comment" v-model="comment" cols="30" rows="3"
                              :class="{'is-invalid': error_list.comment }"
                              class="form-control"></textarea>
                    <div class="invalid-feedback">{{ error_list.comment }}</div>
                  </div>
                </div>
              </div>
            </tab-content>
            <tab-content title="Подтверждение заказа">

              <div class="">
                <table id="cart" class="table table-shopping-cart">
                  <thead>
                  <tr>
                    <th scope="col" class="border-0 bg-light">
                      <div class="p-1 text-uppercase">Товар</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="p-1 text-uppercase">Цена</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="p-1 text-uppercase">Кол-во</div>
                    </th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(cartItem, key, index) in cart.content">
                    <td scope="row" :class="{'border-0': index == 0}">
                      <div class="p-2">
                        <img v-if="cartItem.image"
                             :src="'/storage/files/90x110/'+cartItem.image"
                             class="img-fluid rounded shadow-sm" width="80" alt="Фото товара">
                        <div class="ml-3 d-inline-block align-middle">
                          <h6 class="mb-0">
                            <span href="#" class="text-dark d-inline-block align-middle">{{ cartItem.name }}</span>
                          </h6>
                          <span v-if="cartItem.options.color"
                                class="text-muted font-weight-normal font-italic d-block">
                                    Цвет: {{ cartItem.options.color }}
                                </span>
                          <span v-if="cartItem.options.color_stone"
                                class="text-muted font-weight-normal font-italic d-block">
                                    Цвет камня: {{ cartItem.options.color_stone }}
                                </span>
                        </div>
                      </div>
                      <div id="engravingCart" v-if=" Object.keys(cartItem.engravings).length > 0"
                           class="callout callout-default engraving-list">
                        <b>Гравировка:</b>
                        <div v-for="(engraving, keyEngraving) in cartItem.engravings" class="w-100 text-left d-flex">
                          <div class="flex-fill text-left">
                            <span class="title">{{ engraving.title }}</span>
                            <span class="engraving-text" v-if="engraving.text" data-toggle="tooltip"
                                  :title="engraving.text">текст</span>
                            <a class="link-file" v-if="engraving.filename" data-toggle="tooltip" title="Файл"
                               target="_blank" :href="'/storage/files/'+engraving.filename"><img width="16"
                                                                                                 src="/img/document.png"
                                                                                                 alt=""></a>
                          </div>
                          <div class="flex-fill pl-2 text-right">
                            <span class="qty">{{ engraving.qty }}x</span>
                            <span class="price">{{ engraving.price }} &#8381;</span>
                          </div>

                        </div>
                      </div>
                    </td>
                    <td class="align-middle text-center" :class="{'border-0': index == 0}"
                        data-th="Цена">{{ cartItem.price }} &#8381;
                    </td>
                    <td class="align-middle text-center" :class="{'border-0': index == 0}"
                        data-th="Кол-во">{{ cartItem.qty }}
                    </td>
                  </tr>
                  </tbody>
                </table>

              </div>
            </tab-content>

          </form-wizard>

          <input type="hidden" name="_token" :value="csrf">
        </form>
      </div>
      <div class="col-sm-4 pt-5">
        <div class="bg-light px-4 py-3 text-uppercase font-weight-bold">Код Купона</div>
        <div class="p-4">
          <p class="font-italic mb-4">Введите промокод в поле ниже.</p>
          <div class="input-group mb-4">
            <input type="text" placeholder="Промокод" :class="{'is-invalid': error_coupon}"
                   v-model="coupon_code" aria-describedby="button-addon3" class="py-2 form-control">
            <div class="input-group-append border-0">
              <button type="button" @click="addCouponToCart(coupon_code)" class="btn btn-dark"><i
                  class="fa fa-gift mr-2"></i>Применить
              </button>
            </div>
            <div class="invalid-feedback">{{ error_coupon }}</div>
          </div>
        </div><!-- /Промокод -->
        <div class="bg-light  px-4 py-3 text-uppercase font-weight-bold">Итог заказа</div>
        <div class="p-4">
          <p class="font-italic mb-4">Доставка и дополнительные расходы будут рассчитываться на основе
            введенных Вами значений.</p>
          <ul class="list-unstyled mb-4">
            <li v-if="isCoupon || isShipment"
                class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">Сумма</strong>{{ cart.totalPrice }} &#8381;
            </li>
            <li v-if="isShipment" class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">{{ cart.shipment.title }}</strong>&nbsp;
              <span class="text-nowrap">+ {{ cart.shipmentPrice }} &#8381;</span>
            </li>
            <li v-for="coupon in cart.coupons" class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">Промокод: {{ coupon.name }}</strong>
              <span>- {{ coupon.discount }}&#8381;</span>
            </li>
            <li v-if="cart.totalWithCoupons" class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">Итоговая сумма</strong>
              <h5 class="">{{ cart.totalWithCoupons }} &#8381;</h5>
            </li>
          </ul>
        </div> <!-- /Итоговая цена -->
      </div>

    </div>
  </div>
</template>

<script>
import {FormWizard, TabContent} from 'vue-form-wizard';

export default {
  components: {
    FormWizard,
    TabContent
  },
  props: ['cart', 'countries', 'shipments', 'payments', 'lastOrder', 'route', 'config'],

  mounted() {
    console.log('Component checkout mounted.');

  },

  data: function () {
    return {
      first_name: null,
      last_name: null,
      email: null,
      telephone: null,
      city: null,
      address: null,
      country: null,
      region: null,
      comment: null,
      coupon: null,
      couponItem: null,
      postcode: null,
      company: null,

      payment: null,
      shipment: null,

      message: null,
      errors: [],
      error_coupon: null,
      coupon_code: null,
      error_toggle: false,
      error_list: {},
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }

  },

  created() {
    if (this.lastOrder) {
      this.first_name = this.lastOrder.first_name;
      this.last_name = this.lastOrder.last_name;
      this.email = this.lastOrder.email;
      this.telephone = this.lastOrder.telephone;
      this.company = this.lastOrder.company;
      this.address = this.lastOrder.address;
      this.postcode = this.lastOrder.postcode;
      this.city = this.lastOrder.city;
    }
  },

  methods: {
    text: function () {
      console.log('text');
    },

    async stepFirstValid() {
      try {
        const response = await axios.post('/api/checkout/validStepFirst', {
          first_name: this.first_name,
          last_name: this.last_name,
          email: this.email,
          telephone: this.telephone,
          company: this.company,
          address: this.address,
          postcode: this.postcode,
          city: this.city,
          country: this.country,
        });
        this.errors = null;
        return true
      } catch (error) {
        this.errors = error.response.data.errors;
        return false
      }

    },

    async stepSecondValid() {
      try {
        const response = await axios.post('/api/checkout/validStepSecond', {
          shipment: this.shipment,
          payment: this.payment,
        });
        this.errors = null;
        return true
      } catch (error) {
        this.errors = error.response.data.errors;
        return false
      }
    },


    onComplete: function () {

      document.checkoutForm.submit();
    },


    addCouponToCart(code) {
      const url = '/api/add-coupon/' + code;
      axios.get(url)
          .then((res) => {
            if (res.data.cart) {
              this.$root.cart = res.data.cart;
              this.error_coupon = null
            }
          })
          .catch((error) => {
            console.log(error);
            this.error_coupon = 'Неверный промокод';
          })
    },
    addShipmentToCart(id) {
      const url = '/api/add-shipment/' + id;
      console.log(url);
      axios.get(url)
          .then((res) => {
            if (res.data.cart) {
              this.$root.cart = res.data.cart;
            }
          })
          .catch((error) => {
            console.log(error);
          })
    }


  },

  computed: {
    country_object: function () {
      if (this.country) {
        return this.country.name;
      }
    },

    isCoupon: function () {
      return !_.isEmpty(this.cart.coupons)
    },
    isShipment: function () {
      return !_.isEmpty(this.cart.shipment);
    },

  },


}

</script>

<style>
@import "~vue-form-wizard/dist/vue-form-wizard.min.css";
</style>