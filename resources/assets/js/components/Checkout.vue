<template>
    <div>

        <form :action="route"  method="post" id="checkoutForm" name="checkoutForm">

            <form-wizard  @on-complete="onComplete" shape="square"
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
                                    <select name="country" id="country" v-model="country"  class="form-control">
                                        <option :selected="null" v-bind:value="null">Выбрать</option>
                                        <option v-for="item in countries"  v-bind:value="item.id">{{item.name}}</option>
                                    </select>
                                    <span v-if="errors.country" class="help-block">{{ errors.country }}</span>

                                </div>
                                <div v-if="country" class="form-group" v-bind:class="{'has-error': errors.region }">
                                    <label for="region">Регион/Область</label>
                                    <select  name="region" v-model="region" id="region"
                                            class="form-control">
                                        <option :selected="null" v-bind:value="null">Выбрать</option>
                                        <option v-for="region in countries[country].regions" :value="region.id">{{region.name}}
                                        </option>
                                    </select>
                                    <span v-if="errors.region" class="help-block">{{ errors.region}}</span>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </tab-content>
                <tab-content title="Способ оплаты" :before-change="stepSecondValid">
                    <div class="row">
                        <div class="col-xs-12">
                            <p>Выберите способ оплаты для этого заказа</p>
                            <div class="form-group" v-bind:class="{'has-error': errors.payment }">
                                <div class="radio">
                                    <label class="radio-inline"><input type="radio" name="payment"
                                                                       v-model="payment" value="credit_card">Кредитная
                                        карта</label>
                                </div>
                                <div class="radio">
                                    <label class="radio-inline"><input type="radio" name="payment"
                                                                       v-model="payment" value="qiwi">QIWI
                                        Кошелек</label>
                                </div>
                                <div class="radio">
                                    <label class="radio-inline"><input type="radio" name="payment"
                                                                       v-model="payment" value="yandex">Яндекс
                                        кошелек</label>
                                </div>
                                <div class="radio">
                                    <label class="radio-inline"><input type="radio" name="payment"
                                                                       v-model="payment" value="paypal">Paypal
                                        кошелек</label>
                                </div>
                                <span v-if="errors['payment']" class="help-block">{{errors['payment']}}</span>
                            </div>
                            <div class="form-group" v-bind:class="{'has-error': errors.comment }">
                                <label for="comment">Комментарий</label>
                                <textarea class="form-control" rows="5" name="comment" id="comment" v-model="comment"></textarea>
                                <span v-if="errors.comment" class="help-block">{{ errors.comment}}</span>
                            </div>
                        </div>
                    </div>
                </tab-content>
                <tab-content title="Подтверждение заказа">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Наименование товара</th>
                                <th>Кол-во</th>
                                <th class="text-right">Цена за шт</th>
                                <th class="text-right">Всего</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(cartItem, key, index) in this.$parent.cart.items">
                                <!--<td>{{cartItem.item.id}}</td>-->
                                <td>{{cartItem.item.title}}</td>
                                <td><strong>{{cartItem.qty}}</strong></td>
                                <td>{{cartItem.price/cartItem.qty}} р.</td>
                                <td class="text-right">{{cartItem.price}} р.</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Предварительная стоимость:</strong></td>
                                <td class="text-right">
                                    <strong>{{this.$parent.cart.totalPrice}} р.</strong>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                    <!--<button type="submit" class="btn btn-success">Купить</button>-->
                </tab-content>

            </form-wizard>

        <input type="hidden" name="_token" :value="csrf">
        </form>


        <!--<div class="row">-->

        <!--<div class="col-sm-6">-->
        <!--<h2>Новый покупатель</h2>-->
        <!--<p>Опции оформления заказа:</p>-->
        <!--<div class="radio">-->
        <!--<label><input type="radio" name="payment_method" value="yandex" checked="checked">Зарегистрироваться</label>-->
        <!--</div>-->

        <!--</div>-->
        <!--<div class="col-sm-6">-->
        <!--<h2>Зарегистрированный пользователь</h2>-->
        <!--Я совершал здесь покупки ранее и регистрировался-->
        <!--</div>-->
        <!--</div>-->

    </div>
</template>

<script>
    import {FormWizard, TabContent} from 'vue-form-wizard';
    // import VeeValidate from 'vee-validate';

    // Vue.use(VeeValidate);
    export default {
        components: {
            FormWizard,
            TabContent
        },
        props: ['total', 'countries', 'route', 'cart'],

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
                }else if(!this.validEmail(this.email)) {
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

            stepSecondValid: function(){
                this.errors = [];
                if (!this.payment){
                    console.log(!this.payment);
                    this.errors["payment"] = "Выберите платежную систему."
                }

                if (Object.keys(this.errors).length > 0) {
                    return false
                }
                return true
            },

            onComplete: function(){

                 document.checkoutForm.submit();
                // $("#form-store").trigger('click');

                // document.getElementById('form-store').submit;
            },


            validEmail: function(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        }
    }

</script>

<style>
    @import "~vue-form-wizard/dist/vue-form-wizard.min.css";
</style>