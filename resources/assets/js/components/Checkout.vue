<template>
    <div id="checkout-block">

        <form :action="route" method="post" id="checkoutForm" name="checkoutForm">

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

                                <div class="form-group required" v-bind:class="{'has-error': errors.first_name }">

                                    <label for="first_name">Имя</label>
                                    <input :type="text" id="first_name" name="first_name" v-model="first_name"
                                           class="form-control">
                                    <span v-if="errors.first_name"
                                          class="help-block">{{ errors.first_name }}</span>

                                </div>


                                <div class="form-group required" v-bind:class="{'has-error': errors.last_name }">
                                    <label for="last_name">Фамилия</label>
                                    <input :type="text" id="last_name" name="last_name" v-model="last_name"
                                           class="form-control">
                                    <span v-if="errors.last_name" class="help-block">{{errors.last_name}}</span>
                                </div>

                                <div class="form-group required" v-bind:class="{'has-error': errors.email}">
                                    <label for="email">E-mail</label>
                                    <input :type="text" id="email" name="email" v-model="email" class="form-control">
                                    <span v-if="errors.email" class="help-block">{{ errors.email }}</span>
                                </div>

                                <div class="form-group required" v-bind:class="{'has-error': errors.telephone }">
                                    <label for="telephone">Телефон</label>
                                    <input :type="text" id="telephone" name="telephone" v-model="telephone"
                                           class="form-control">
                                    <span v-if="errors.telephone" class="help-block">{{ errors.telephone}}</span>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Адрес</legend>
                                <div class="form-group" v-bind:class="{'has-error': errors.company }">
                                    <label for="company">Компания</label>
                                    <input :type="text" id="company" name="company" v-model="company"
                                           class="form-control">
                                    <span v-if="errors.company" class="help-block">{{ errors.company}}</span>
                                </div>
                                <div class="form-group required" v-bind:class="{'has-error': errors.address }">
                                    <label for="address">Адрес</label>
                                    <input :type="text" id="address" name="address" class="form-control"
                                           v-model="address">
                                    <span v-if="errors.address" class="help-block">{{ errors.address }}</span>
                                </div>
                                <div class="form-group" v-bind:class="{'has-error': errors.postcode }">
                                    <label for="postcode">Индекс</label>
                                    <input :type="text" id="postcode" name="postcode" v-model="postcode"
                                           class="form-control">
                                    <span v-if="errors.postcode" class="help-block">{{ errors.postcode }}</span>
                                </div>
                                <div class="form-group required" v-bind:class="{'has-error': errors.city }">
                                    <label for="city">Город</label>
                                    <input :type="text" id="city" name="city" v-model="city" class="form-control">
                                    <span v-if="errors.city" class="help-block">{{ errors.city }}</span>
                                </div>

                                <div class="form-group required" v-bind:class="{'has-error': errors.country }">
                                    <label for="country">Страна</label>
                                    <select name="country" id="country" v-model="country" class="form-control">
                                        <option :selected="null" v-bind:value="null">Выбрать</option>
                                        <option v-for="item in countries" v-bind:value="item.id">{{item.name}}</option>
                                    </select>
                                    <span v-if="errors.country" class="help-block">{{ errors.country }}</span>

                                </div>
                                <div v-if="country" class="form-group" v-bind:class="{'has-error': errors.region }">
                                    <label for="region">Регион/Область</label>
                                    <select name="region" v-model="region" id="region"
                                            class="form-control">
                                        <option :selected="null" v-bind:value="null">Выбрать</option>
                                        <option v-for="region in countries[country].regions" :value="region.id">
                                            {{region.name}}
                                        </option>
                                    </select>
                                    <span v-if="errors.region" class="help-block">{{ errors.region}}</span>
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
                                <div class="form-group" v-bind:class="{'has-error': errors.payment }">
                                    <div class="radio">
                                        <label for="credit_card" class="radio-inline">
                                            <input id="credit_card" type="radio" name="payment" v-model="payment"
                                                   value="credit_card">
                                            <img src="/img/sber.jpg" alt=""> Кредитная карта
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="qiwi" class="radio-inline">
                                            <input id="qiwi" type="radio" name="payment" v-model="payment" value="qiwi">
                                            <img src="/img/qiwi.png" alt="">QIWI Кошелек
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="yandex" class="radio-inline">
                                            <input id="yandex" type="radio" name="payment" v-model="payment"
                                                   value="yandex">
                                            <img src="/img/yandex.jpg" alt=""> Яндекс кошелек
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="paypal" class="radio-inline">
                                            <input type="radio" name="payment" id="paypal" v-model="payment"
                                                   value="paypal">
                                            <img src="/img/paypal.jpg" alt=""> Paypal кошелек
                                        </label>
                                    </div>
                                    <span v-if="errors['payment']" class="help-block">{{errors['payment']}}</span>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <fieldset>
                                <legend>Выбрать способ доставки</legend>
                                <div class="form-group" v-bind:class="{'has-error': errors.shipment }">
                                    <div class="radio">
                                        <label for="pochta_ru" class="radio-inline">
                                            <input id="pochta_ru" v-model="shipment" type="radio" value="pochta_ru"
                                                   name="shipment">
                                            <span class="img-shipp"><img src="/img/ship3.gif" alt="Почта России"></span>
                                            Доставка почтой по России <span v-if="country">(наценка + {{shipmentCountry('pochta_ru')}})</span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="pochta_gl" class="radio-inline">
                                            <input id="pochta_gl" v-model="shipment" type="radio" value="pochta_gl"
                                                   name="shipment">
                                            <span class="img-shipp"><img src="/img/ship3.gif" alt="Почта России"></span>
                                            Доставка почтой за пределы России <span v-if="country">(наценка + {{shipmentCountry('pochta_gl')}})</span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="cdek" class="radio-inline">
                                            <input id="cdek" v-model="shipment" type="radio" value="cdek"
                                                   name="shipment">
                                            <span class="img-shipp"><img src="/img/cdek.jpg" alt="Почта России"></span>
                                            СДЭК пункт выдачи
                                        </label>
                                    </div>
                                    <span v-if="errors['shipment']" class="help-block">{{errors['shipment']}}</span>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <hr>
                            <div style="max-width: 180px" class="form-group">
                                <label for="coupon">Промокод</label>
                                <input v-on:change="isCoupon" v-model="coupon" type="text" name="coupon" id="coupon"
                                       class="form-control">
                            </div>
                            <div class="form-group" v-bind:class="{'has-error': errors.comment }">
                                <label for="comment">Комментарий</label>
                                <textarea class="form-control" rows="5" name="comment" id="comment"
                                          v-model="comment"></textarea>
                                <span v-if="errors.comment" class="help-block">{{ errors.comment}}</span>
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
                                <td colspan="3" class="text-right"><strong>{{this.paymentConfig.shipment_method[this.shipment].method}}</strong></td>
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
        props: ['total', 'countries', 'coupons', 'route', 'cart', 'paymentConfig'],

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

                errors: [],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }

        },
        methods: {

            stepFirstValid: function () {
                this.errors = [];
                if (!this.first_name) this.errors["first_name"] = "Укажите имя.";
                if (!this.last_name) this.errors["last_name"] = "Укажите фамилию.";
                if (!this.email) {
                    this.errors["email"] = "Укажите электронную почту.";
                } else if (!this.validEmail(this.email)) {
                    this.errors["email"] = "Укажите корректный адрес электронной почты.";
                }
                if (!this.telephone) this.errors["telephone"] = "Укажите  телефон.";
                if (!this.address) this.errors["address"] = "Укажите адрес.";
                if (!this.city) this.errors["city"] = "Укажите город проживания.";
                if (!this.country) this.errors["country"] = "Укажите страну проживания.";

                if (Object.keys(this.errors).length > 0) {
                    return false
                }
                return true
            },

            stepSecondValid: function () {
                this.errors = [];
                if (!this.payment) {
                    this.errors["payment"] = "Выберите платежную систему."
                }
                if (!this.shipment) {
                    this.errors["shipment"] = "Выберите способ оплаты."
                }
                if (Object.keys(this.errors).length > 0) {
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
                if (this.shipment ){
                    total = total + parseFloat(this.shipmentCountry(this.shipment));
                }
                if (this.couponItem){
                  total =  total - parseFloat(total*this.couponItem.discount/100);
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