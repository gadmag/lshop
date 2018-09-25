<template>
    <div class="shopping-cart">
        <div v-if="carttotal > 0">
            <table id="cart" class="table table-shopping-cart table-hover table-condensed">
                <thead>
                <tr>
                    <th style="width:50%">Наименование</th>
                    <th style="width:10%">Цена</th>
                    <th style="width:10%">Кол-во</th>
                    <th style="width:20%" class="text-center">Итого</th>
                    <th style="width:10%"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(cartItem, key, index) in cart.items">
                    <td class="title" data-th=" ">
                        <div class="row">
                            <div class="col-sm-3 col-xs-4"><img v-if="cartItem.item.files[0]" class="img-responsive"
                                                                 :src="'/storage/files/90x110/'+cartItem.item.files[0].filename"
                                                                 alt="Картинка товара"></div>
                            <div class="col-sm-9 col-xs-8">{{cartItem.item.title}}</div>
                        </div>
                    </td>
                    <td class="price" data-th="Цена">{{cartItem.price/cartItem.qty}} р.</td>
                    <td data-th="Кол-во">
                        <a href="#" @click="reduceFromCart(key)" type="button"><i
                                class="fa fa-minus"></i></a>
                        <strong>{{cartItem.qty}}</strong>
                        <a href="#" @click="addToCart(key)" type="button"><i
                                class="fa fa-plus"></i></a>
                    </td>
                    <td data-th="Итого" class="text-center">{{cartItem.price}} р.</td>
                    <td class=" text-center actions"><a @click="removeFromCart(key)" href="#"><i class="fa fa-remove"></i></a></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>

                    <td colspan="3" class="hidden-xs"></td>
                    <td><strong>Итоговая сумма:</strong></td>
                    <td class="text-center"><strong> {{cart.totalPrice}} р.</strong></td>
                </tr>
                </tfoot>
            </table>
            <div class="clearfix"></div>
            <div class="checkout-button">
                <div class="pull-right">
                    <a href="/" style="max-width: 200px; display: inline-block" class="hidden-xs lotus-button"><i
                            class="fa fa-angle-left"></i> Продолжить покупки</a>
                    <a style="max-width: 160px; display: inline-block" :href="route" class="lotus-button ">Оформить
                        заказ <i class="fa fa-angle-right"></i></a>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['cart', 'carttotal', 'route', 'minsum'],
        mounted() {
            console.log('Component Cart detail mounted.');

        },

        methods: {
            removeFromCart(item) {
                bus.$emit('remove-from-cart', item)
            },
            reduceFromCart(item) {
                bus.$emit('reduce-from-cart', item)
            },
            addToCart(item) {
                bus.$emit('added-to-cart', item)
            }
        }
    }
</script>
