<template>
    <div class="cart-detail">
        <div v-if="carttotal > 0" class="">
            <div class="table-responsive">
                <table class="table table-detail table-hover">
                    <thead>
                    <tr>
                        <th>Фото</th>
                        <th>Наименование</th>
                        <th>Цена</th>
                        <th>Кол-во</th>
                        <th>Итого</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(cartItem, key, index) in cart.items">
                        <!--<td>{{key}}</td>-->

                        <td class="img-cart"><img v-if="cartItem.item.files[0]" class="img-responsive"
                                                  :src="'/storage/files/90x110/'+cartItem.item.files[0].filename"
                                                  alt="Картинка товара"></td>
                        <td>{{cartItem.item.title}}</td>
                        <td>{{cartItem.price/cartItem.qty}} р.</td>
                        <td>
                            <div style="min-width: 100px" class="">
                                <span @click="reduceFromCart(key)" type="button"><i class="fa fa-minus"></i></span>  <b>{{cartItem.qty}}</b>
                                <span @click="addToCart(key)" type="button"><i class="fa fa-plus"></i></span>
                            </div>

                        </td>
                        <td>{{cartItem.price}} р.</td>
                        <td><a @click="removeFromCart(key)" href="#"><i class="fa fa-remove"></i></a></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-left">
                            <a href="/shopping-cart" class="btn btn-default">Просмотр корзины</a>
                        </td>
                        <td colspan="2" class="text-right">
                            <strong>Итого: {{cart.totalPrice}} р.</strong>
                        </td>
                    </tr>
                    <!--<div>{{carttotal}}</div>-->
                    </tbody>
                </table>

            </div>
        </div>
        <div class="empty-cart" v-else>
            <p class="text-center">Корзина пуста</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['cart', 'carttotal'],
        mounted() {
            console.log('Component Cart detail mounted.');

        },

        methods: {
            removeFromCart(id) {
                bus.$emit('remove-from-cart', id)
            },
            reduceFromCart(key) {

                bus.$emit('reduce-from-cart', key)
            },
            addToCart(item) {
                bus.$emit('added-to-cart', item)
            }
        }
    }
</script>
