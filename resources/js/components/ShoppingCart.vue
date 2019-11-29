<template>
    <div v-if="isCart" class="shopping-cart">

        <div v-if="!(cart.totalPrice >= minsum)" class="alert alert-danger">
            <div class="text-center">Минимальная сумма заказа {{minsum}} р.</div>
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
                                <h6 class="mb-0">
                                    <span href="#"
                                          class="text-dark d-inline-block align-middle">{{cartItem.name}}</span>
                                </h6>
                                <span v-if="cartItem.options.color"
                                      class="text-muted font-weight-normal font-italic d-block">
                                    Цвет: {{cartItem.options.color}}
                                </span>
                                <span v-if="cartItem.options.color_stone"
                                      class="text-muted font-weight-normal font-italic d-block">
                                    Цвет камня: {{cartItem.options.color_stone}}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle text-center" :class="{'border-0': index == 0}" data-th="Цена"><strong>{{cartItem.price}}
                        р.</strong>
                    </td>
                    <td class="align-middle text-center" :class="{'border-0': index == 0}" data-th="Кол-во">
                        <a href="#" @click="reduceFromCart(key)"><i class="fa fa-minus"></i></a>
                        <strong>{{cartItem.qty}}</strong>
                        <a href="#" @click="addToCart(cartItem)"><i class="fa fa-plus"></i></a>
                    </td>
                    <td data-th="Итого" class="align-middle text-center" :class="{'border-0': index == 0}"><strong>{{cartItem.price
                        *
                        cartItem.qty}} р.</strong></td>
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
                        <div class="invalid-feedback">{{error_coupon}}</div>
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
                            <strong class="text-muted">Сумма</strong><strong>{{cart.totalPrice}} р.</strong>
                        </li>
                        <li v-for="coupon in cart.coupons" class="d-flex justify-content-between py-3 border-bottom">
                            <strong class="text-muted">Промокод: {{coupon.name}}</strong><strong>- {{coupon.discount}}
                            р</strong>
                        </li>
                        <li v-if="cart.totalWithCoupons" class="d-flex justify-content-between py-3 border-bottom">
                            <strong class="text-muted">Итоговая сумма</strong>
                            <h5 class="font-weight-bold">{{cart.totalWithCoupons}} р.</h5>
                        </li>
                    </ul>
                    <div class="checkout-button">
                        <a :href="route">
                            <button class="btn btn-dark py-2 btn-block" :disabled="!(cart.totalPrice >= minsum)">
                                Оформить заказ <i
                                    class="fa fa-angle-right"></i></button>
                        </a>
                    </div>
                </div>
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
    export default {
        props: ['cart', 'route', 'minsum'],
        data: function () {
            return {
                coupon_code: null,
                error_coupon: null
            }
        },
        mounted() {
            console.log('Component Cart detail mounted.');

        },

        computed: {
          isCart: function () {
              if (this.cart && _.size(this.cart.content)){
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
                bus.$emit('added-to-cart', item.id, options)
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
