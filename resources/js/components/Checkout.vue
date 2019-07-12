<template>
    <div id="checkout-block">

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

                    <div class="row">
                        <div class="col-sm-6">

                            <fieldset>

                                <legend>Личные данные</legend>

                                <div class="form-group required">
                                    <input :type="text" id="first_name" placeholder="Имя" name="first_name"
                                           v-model="first_name"
                                           class="form-control" :class="{'is-invalid': error_list.first_name}">
                                    <div class="invalid-feedback">{{ error_list.first_name }}</div>

                                </div>


                                <div class="form-group required">
                                    <input :type="text" id="last_name" placeholder="Фамилия" name="last_name"
                                           v-model="last_name"
                                           class="form-control" :class="{'is-invalid': error_list.last_name }">
                                    <div class="invalid-feedback">{{error_list.last_name}}</div>
                                </div>

                                <div class="form-group required">
                                    <input :type="text" id="email" placeholder="E-mail" name="email" v-model="email"
                                           class="form-control" :class="{'is-invalid': error_list.email}">
                                    <div class="invalid-feedback">{{ error_list.email }}</div>
                                </div>

                                <div class="form-group required">
                                    <input :type="text" id="telephone" placeholder="Телефон" name="telephone"
                                           v-model="telephone"
                                           class="form-control" :class="{'is-invalid': error_list.telephone }">
                                    <div class="invalid-feedback">{{ error_list.telephone}}</div>
                                </div>
                                <div class="form-group">
                                    <!--                                    <label for="company">Компания</label>-->
                                    <input :type="text" id="company" placeholder="Компания" name="company"
                                           v-model="company"
                                           class="form-control" :class="{'is-invalid': error_list.company }">
                                    <div class="invalid-feedback">{{ error_list.company}}</div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Адрес</legend>
                                <div class="form-group required">
                                    <input :type="text" id="address" placeholder="Адрес" name="address"
                                           class="form-control"
                                           v-model="address" :class="{'is-invalid': error_list.address }">
                                    <div class="invalid-feedback">{{ error_list.address }}</div>
                                </div>
                                <div class="form-group">
                                    <input :type="text" id="postcode" placeholder="Индекс" name="postcode"
                                           v-model="postcode"
                                           class="form-control" :class="{'is-invalid': error_list.postcode }">
                                    <div class="invalid-feedback">{{ error_list.postcode }}</div>
                                </div>
                                <div class="form-group required">
                                    <input :type="text" id="city" placeholder="Город" name="city" v-model="city"
                                           class="form-control" :class="{'is-invalid': error_list.city }">
                                    <div class="invalid-feedback">{{ error_list.city }}</div>
                                </div>

                                <div class="form-group required">
                                    <select name="country" id="country" v-model="country"
                                            class="form-control" :class="{'is-invalid': error_list.country }">
                                        <option :selected="null" v-bind:value="null">Выбрать страну</option>
                                        <option v-for="item in countries" v-bind:value="item.id">{{item.name}}</option>
                                    </select>
                                    <div class="invalid-feedback">{{ error_list.country }}</div>

                                </div>
                                <div v-if="country" class="form-group">
                                    <select name="region" v-model="region" id="region"
                                            class="form-control" :class="{'is-invalid': error_list.region }">
                                        <option :selected="null" v-bind:value="null">Выбрать регион</option>
                                        <option v-for="region in countries[country].regions" :value="region.id">
                                            {{region.name}}
                                        </option>
                                    </select>
                                    <div class="is-invalid">{{ error_list.region}}</div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </tab-content>
                <tab-content title="Способ оплаты и доставки" :before-change="stepSecondValid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <fieldset>
                                <legend>Выберите способ оплаты</legend>
                                <div class="form-group" :class="{'is-invalid': error_list.payment }">
                                    <div class="custom-control custom-radio">
                                        <input id="credit_card" type="radio" name="payment" v-model="payment"
                                               value="credit_card" class="custom-control-input">
                                        <label for="credit_card" class="custom-control-label">
                                            <img src="/img/sber.jpg" alt="Банковская карта"> Банковская карта
                                        </label>

                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="qiwi" type="radio" name="payment" v-model="payment"
                                               value="qiwi" class="custom-control-input">
                                        <label for="qiwi" class="custom-control-label">
                                            <img src="/img/qiwi.png" alt="">QIWI Кошелек
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="yandex" type="radio" name="payment" v-model="payment"
                                               value="yandex" class="custom-control-input">
                                        <label for="yandex" class="custom-control-label">
                                            <img src="/img/yandex.jpg" alt=""> Яндекс кошелек
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="payment" id="paypal" v-model="payment"
                                               value="paypal" class="custom-control-input">
                                        <label for="paypal" class="custom-control-label">
                                            <img src="/img/paypal.jpg" alt=""> Paypal кошелек
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="payment" id="cash" v-model="payment"
                                               value="cash" class="custom-control-input">
                                        <label for="cash" class="custom-control-label">
                                            <img src="/img/cash.png" alt=""> Оплата при получении
                                        </label>
                                    </div>
                                    <div class="invalid-feedback">{{error_list.payment}}</div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <fieldset>
                                <legend>Выбрать способ доставки</legend>
                                <div class="form-group" :class="{'is-invalid': error_list.shipment }">
                                    <div class="custom-control custom-radio">
                                        <input id="pochta_ru" v-model="shipment" type="radio" value="pochta_ru"
                                               name="shipment" class="custom-control-input">
                                        <label for="pochta_ru" class="custom-control-label">
                                            <span class="img-shipp"><img src="/img/ship3.gif" alt="Почта России"></span>
                                            Доставка почтой по России <span v-if="country">(наценка + {{shipmentCountry('pochta_ru')}})</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="pochta_gl" v-model="shipment" type="radio" value="pochta_gl"
                                               name="shipment" class="custom-control-input">
                                        <label for="pochta_gl" class="custom-control-label">
                                            <span class="img-shipp"><img src="/img/ship3.gif" alt="Почта России"></span>
                                            Доставка почтой за пределы России <span v-if="country">(наценка + {{shipmentCountry('pochta_gl')}})</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="cdek" v-model="shipment" type="radio" value="cdek"
                                               name="shipment" class="custom-control-input">
                                        <label for="cdek" class="custom-control-label">
                                            <span class="img-shipp"><img src="/img/cdek.jpg" alt="Почта России"></span>
                                            СДЭК пункт выдачи
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">

                                        <input id="pickup" v-model="shipment" type="radio" value="pickup"
                                               name="shipment" class="custom-control-input">
                                        <label for="pickup" class="custom-control-label">
                                            <span class="img-shipp"><img src="/img/pickup.png" alt="Самовывоз"></span>
                                            Самовывоз
                                        </label>
                                    </div>
                                    <div class="invalid-feedback">{{error_list.shipment}}</div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <hr>
                            <div style="max-width: 180px" class="form-group">
                                <label for="coupon">Промокод</label>
                                <input v-on:change="isCoupon" v-model="coupon" type="text" name="coupon" id="coupon"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="comment">Комментарий</label>
                                <textarea class="form-control" :class="{'is-invalid': error_list.comment }" rows="5"
                                          name="comment" id="comment"
                                          v-model="comment"></textarea>
                                <div class="invalid-feedback">{{ error_list.comment}}</div>
                            </div>
                        </div>
                    </div>
                </tab-content>
                <tab-content title="Подтверждение заказа">

                    <div class="">
                        <table id="cart" class="table table-shopping-cart table-hover table-condensed">
                            <thead>
                            <tr>
                                <th style="width: 55%">Наименование</th>
                                <th style="width: 10%">Кол-во</th>
                                <th style="width: 15%">Цена за шт</th>
                                <th style="width: 20%" class="text-right">Всего</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(cartItem, key, index) in this.$parent.cart.items">
                                <!--<td>{{cartItem.item.id}}</td>-->
                                <td class="title">{{cartItem.item.title}}</td>
                                <td data-th="Кол-во"><strong>{{cartItem.qty}}</strong></td>
                                <td data-th="Цена">{{cartItem.price/cartItem.qty}} р.</td>
                                <td data-th="Итого" class="text-right">{{cartItem.price}} р.</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Предварительная стоимость:</strong></td>
                                <td class="text-right">
                                    <strong>{{this.$parent.cart.totalPrice}} р.</strong>
                                </td>
                            </tr>
                            <tr v-if="this.shipment">
                                <td colspan="3" class="text-right"><strong>{{this.paymentConfig.shipment_method[this.shipment].method}}</strong>
                                </td>
                                <td class="text-right"><strong>{{this.shipmentCountry(this.shipment)}} р</strong></td>
                            </tr>
                            <tr v-if="this.couponItem">
                                <td colspan="3" class="text-right"><strong>Промокод:</strong></td>
                                <td class="text-right"><strong>{{this.couponItem.name}}</strong></td>
                            </tr>
                            <tr v-if="activeSum">
                                <td colspan="3" class="text-right"><strong>Итоговая сумма:</strong></td>
                                <td class="text-right"><strong>{{getTotalPrice()}} р.</strong></td>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </tab-content>

            </form-wizard>

            <input type="hidden" name="_token" :value="csrf">
        </form>

    </div>
</template>

<script>
    import {FormWizard, TabContent} from 'vue-form-wizard';

    export default {
        components: {
            FormWizard,
            TabContent
        },
        props: ['total', 'countries', 'coupons', 'lastOrder', 'route', 'cart', 'paymentConfig'],

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
                payment: null,
                shipment: null,
                coupon: null,
                couponItem: null,
                postcode: null,
                company: null,

                error_toggle: false,
                error_list: {},
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }

        },

        created() {
            console.log(this.lastOrder);
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

            stepFirstValid: function () {
                this.error_list = [];
                this.error_toggle = false;
                if (!this.first_name) this.error_list["first_name"] = "Укажите имя.";
                if (!this.last_name) this.error_list["last_name"] = "Укажите фамилию.";
                if (!this.email) {
                    this.error_list["email"] = "Укажите электронную почту.";
                } else if (!this.validEmail(this.email)) {
                    this.error_list["email"] = "Укажите корректный адрес электронной почты.";
                }
                if (!this.telephone) this.error_list["telephone"] = "Укажите  телефон.";
                if (!this.address) this.error_list["address"] = "Укажите адрес.";
                if (!this.city) this.error_list["city"] = "Укажите город проживания.";
                if (!this.country) this.error_list["country"] = "Укажите страну проживания.";

                if (Object.keys(this.error_list).length > 0) {
                    this.error_toggle = true;
                    return false
                }

                return true
            },

            stepSecondValid: function () {
                this.error_list = [];
                if (!this.payment) {
                    this.error_list["payment"] = "Выберите платежную систему."
                }
                if (!this.shipment) {
                    this.error_list["shipment"] = "Выберите способ оплаты."
                }
                if (Object.keys(this.error_list).length > 0) {
                    return false
                }
                return true
            },

            onComplete: function () {

                document.checkoutForm.submit();
            },


            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },

            isCoupon: function () {
                if (this.coupon) {
                    this.coupons.filter((item) => {
                        if (item.code.includes(this.coupon)) {
                            this.couponItem = item;
                            return true
                        }
                        return false;
                    })
                }

            },

            checkWeight: function (weight, shipments) {
                if (this.$parent.cart.totalPrice >= this.paymentConfig.cart_setting.free_shipping) {
                    return 0;
                } else {
                    for (var key in shipments) {
                        if (weight <= key) {
                            return shipments[key];
                        }
                    }
                }

            },

            shipmentCountry: function (shipment) {
                var weight = this.$parent.cart.totalWeight;
                if (this.country) {
                    return this.checkWeight(weight, this.paymentConfig.shipment_method[shipment]);
                }
            },

            getTotalPrice: function () {
                var total = parseFloat(this.$parent.cart.totalPrice);
                if (this.shipment) {
                    total = total + parseFloat(this.shipmentCountry(this.shipment));
                }
                if (this.couponItem) {
                    total = total - parseFloat(total * this.couponItem.discount / 100);
                }
                return total;
            }


        },

        computed: {
            activeSum: {
                get: function () {
                    return this.couponItem || this.shipment;
                }
            }
        },


    }

</script>

<style>
    @import "~vue-form-wizard/dist/vue-form-wizard.min.css";
</style>