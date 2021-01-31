<template>
  <div v-if="isCart" class="shopping-cart">

    <div v-if="!(cart.totalPrice >= minsum)" class="alert alert-danger">
      <div class="text-center">Минимальная сумма заказа {{ minsum }} &#8381;</div>
    </div>
    <div class="table-responsive" v-if="cart.totalQty > 0">
      <table id="cart" class="table table-shopping-cart">
        <thead>
        <tr>
          <th scope="col" class="border-0 bg-light">
            <div class="p-2 px-3 text-uppercase">Товар</div>
          </th>
          <th scope="col" class="border-0 bg-light">
            <div class="p-2 px-3 text-uppercase">Цена</div>
          </th>
          <th scope="col" class="border-0 bg-light">
            <div class="p-2 px-3 text-uppercase">Кол-во</div>
          </th>
          <th scope="col" class="text-center border-0 bg-light">
            <div class="p-2 px-3 text-uppercase">Итого</div>
          </th>
          <th scope="col" class="border-0 bg-light"></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(cartItem, key, index) in cart.content">
          <td scope="row" :class="{'border-0': index == 0}">
            <div class="p-2">
              <img v-if="cartItem.image" :src="'/storage/files/90x110/'+cartItem.image"
                   class="img-fluid rounded shadow-sm" alt="Фото товара">
              <div class="ml-3 d-inline-block align-middle">
                <h6 class="mb-0"><span href="#" class="text-dark d-inline-block align-middle">{{ cartItem.name }}</span>
                </h6>
                <span v-if="cartItem.options.color"
                      class="text-muted font-weight-normal font-italic d-block">
                                    Цвет: {{ cartItem.options.color }}
                                </span>
                <span v-if="cartItem.options.color_stone"
                      class="text-muted font-weight-normal font-italic d-block">
                                    Цвет камня: {{ cartItem.options.color_stone }}
                                </span>

                <div id="engravingCart" v-if=" Object.keys(cartItem.engravings).length > 0"
                     class="callout callout-default engraving-list">
                  <b>Гравировка:</b>
                  <div v-for="(engraving, keyEngraving) in cartItem.engravings" class="w-100 text-left d-flex">
                    <div class="flex-fill text-left">
                      <span class="title">{{ engraving.title }}</span>
                      <span class="font">{{ engraving.font }}</span>
                      <a class="link-file px-1" v-if="engraving.filename" data-toggle="tooltip" title="Файл"
                         target="_blank" :href="'/storage/files/'+engraving.filename"><i class="fa fa-file-alt"></i></a>
                     <div class="dropdown d-inline-block">
                     <a v-if="engraving.text" v-text="`текст`" class="dropdown-toggle px-1" href="#" role="button"
                          id="dropdownText" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                       <div v-if="engraving.text" class="dropdown-menu" aria-labelledby="dropdownText">
                         <span class="dropdown-item-text">{{ engraving.text }}</span>
                       </div>
                     </div>
                      <div class="dropdown d-inline-block">
                        <a v-if="engraving.comment" v-text="`комментарий`" class="dropdown-toggle px-1" href="#"
                           role="button" id="dropdownComment" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false"></a>
                        <div v-if="engraving.comment" class="dropdown-menu" aria-labelledby="dropdownComment">
                          <span class="dropdown-item-text">{{ engraving.comment }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="flex-fill pl-2 text-right">
                      <span class="qty">{{ engraving.qty }}x</span>
                      <span class="price">{{ engraving.price }} &#8381;</span>
                      <button @click="editEngraving(engraving, cartItem.item.services)" title="Редактировать"  data-target="#engravingModal"
                              type="button" class="btn btn-link pr-1 pl-2 py-0" data-toggle="modal">
                        <i class="fal fa-edit"></i>
                      </button>
                      <button @click="removeEngraving(key,keyEngraving)" title="Удалить"
                            class="btn btn-link  p-0 text-danger"><i class="fal fa-times"></i></button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div v-if="cartItem.item.services && cartItem.item.services.length >0"
                 class="text-right add-engraving-cart">
              <button @click="openModal(key,cartItem.item)" type="button" class="btn btn-link" data-toggle="modal"
                      data-target="#engravingModal">
                <i class="fa fa-plus"></i> Добавить гравировку
              </button>
            </div>
          </td>
          <td class="align-middle text-center" :class="{'border-0': index == 0}" data-th="Цена">{{ cartItem.price }}
            &#8381;
          </td>
          <td class="align-middle text-center" :class="{'border-0': index == 0}" data-th="Кол-во">
            <a href="#" v-on:click.stop.prevent="reduceFromCart(key)"><i class="far fa-minus"></i></a>
            <strong>{{ cartItem.qty }}</strong>
            <a href="#" v-on:click.stop.prevent="addToCart(cartItem)"><i class="far fa-plus"></i></a>
          </td>
          <td data-th="Итого" class="align-middle text-center" :class="{'border-0': index == 0}">
            {{ cartItem.totalPrice }} &#8381;
          </td>
          <td class="align-middle text-center actions" :class="{'border-0': index == 0}"><a
              @click="removeFromCart(key)" href="#"><i
              class="fa fa-times"></i></a></td>
        </tr>
        </tbody>
      </table>
      <div class="clearfix"></div>
    </div><!-- table responsive -->
    <div class="row pt-4">
      <div class="col-lg-6">
        <div class="bg-light px-4 py-3 text-uppercase font-weight-bold">Код Купона</div>
        <div class="p-4">
          <p class="font-italic mb-4">Введите промокод в поле ниже.</p>
          <div class="input-group mb-4">
            <input type="text" placeholder="Промокод" :class="{'is-invalid': error_coupon}"
                   v-model="coupon_code" aria-describedby="button-addon3" class="py-2 form-control">
            <div class="input-group-append border-0">
              <button id="button-addon3" type="button" @click="addCouponToCart(coupon_code)"
                      class="btn btn-dark"><i class="fa fa-gift mr-2"></i>Применить
              </button>
            </div>
            <div class="invalid-feedback">{{ error_coupon }}</div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="bg-light  px-4 py-3 text-uppercase font-weight-bold">Итог заказа</div>
        <div class="p-4">
          <p class="font-italic mb-4">Доставка и дополнительные расходы будут рассчитываться на основе
            введенных Вами значений.</p>
          <ul class="list-unstyled mb-4">
            <li v-if="cart.coupons.length > 0" class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">Сумма</strong>{{ cart.totalPrice }} &#8381;
            </li>
            <li v-for="coupon in cart.coupons" class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">Промокод: {{ coupon.name }}</strong><strong>- {{ coupon.discount }}
              &#8381;</strong>
            </li>
            <li v-if="cart.totalWithCoupons" class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">Итоговая сумма</strong>
              <h5 class="">{{ cart.totalWithCoupons }} &#8381;</h5>
            </li>
          </ul>
          <div class="checkout-button">
            <a :href="route">
              <button class="btn btn-dark py-2 btn-block" :disabled="!(cart.totalPrice >= minsum)">
                Оформить заказ <i class="fa fa-angle-right"></i></button>
            </a>
          </div>
        </div>
        <engraving :title-type="titleType" :cart-key="cartKey"
                   :fonts="fonts" :engraving="engraving" :services="services"></engraving>
      </div>
    </div>
  </div>
  <div v-else>
    <div class="row">
      <div class="col-12">
        <h5 class="text-center"><span>Нет товаров в корзине</span></h5>
      </div>
    </div>
  </div>
</template>

<script>
import Engraving from './Engraving.vue';

export default {
  components: {
    Engraving
  },
  props: ['cart', 'route', 'fonts', 'minsum'],
  data: function () {
    return {
      services: '',
      cartKey: '',
      coupon_code: null,
      error_coupon: null,
      titleType: 'Добавить',
      engraving: {
        id: '',
        price: '',
        text: '',
        font: '',
        comment: '',
        filename: '',
        cartItemId: '',
        qty: 1
      }
    }
  },
  mounted() {
    console.log('Component Cart detail mounted.');

  },

  computed: {
    isCart: function () {
      if (this.cart && _.size(this.cart.content)) {
        return true;
      }
      return false;
    }
  },

  methods: {
    removeFromCart(item) {
      bus.$emit('remove-from-cart', item)
    },
    reduceFromCart(item) {
      bus.$emit('reduce-from-cart', item)
    },

    addToCart(item) {
      let options = {
        id: item.options.id,
        quantity: 1,
      };
      let url = '/api/add-to-cart/' + item.id + '?options=' + JSON.stringify(options);
      axios.get(url)
          .then(function (response) {
            if (response.data.cart) {
              bus.$emit('added-to-cart', response.data);
            }
          }.bind(this))
          .catch(function (error) {
            console.log(error)
          }.bind(this));
    },
    openModal(key, item) {
      this.titleType = "Добавить";
      this.cartKey = key;
      this.services = item.services;
    },
    editEngraving(engraving, services ){
      this.engraving = JSON.parse(JSON.stringify(engraving));
      this.titleType = "Редактировать";
      this.services = services;

    },
    removeEngraving(keyCartItem, keyEngraving) {
      let options = {keyCartItem, keyEngraving}

      const url = 'api/remove-engraving?options=' + JSON.stringify(options);
      axios.get(url)
          .then((res) => {
            if (res.data.cart) {
              this.$root.cart = res.data.cart;
            }
          })
          .catch((error) => {
            console.log(error);
          })
    },
    addCouponToCart(code) {
      const url = 'api/add-coupon/' + code;
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
    }
  }
}
</script>
