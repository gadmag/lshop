<template>
    <div class="shopping-cart">
        <div v-if="!(cart.totalPrice >= minsum)" class="alert alert-danger">
            <div class="text-center">Минимальная сумма заказа {{minsum}} р.</div>
        </div>
        <div v-if="carttotal > 0">
            <table id="cart" class="table table-shopping-cart table-hover table-condensed">
                <thead class="text-muted">
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
                        <figure class="media">
                            <div class="mr-2 img-wrap">
                                <img v-if="cartItem.optionImage"
                                     :src="'/storage/files/90x110/'+cartItem.optionImage.filename" class="img-thumbnail img-sm" alt="Фото товара">
                                <img v-else-if="cartItem.item.files[0]"
                                     :src="'/storage/files/90x110/'+cartItem.item.files[0].filename"
                                     class="img-thumbnail img-sm" alt="Фото товара">
                            </div>
                            <div class="media-body">
                                <figcaption>{{cartItem.item.title}}</figcaption>
                                <div v-if="cartItem.item.color" class="small">
                                    <span><strong>Цвет:</strong> {{cartItem.item.color}}</span>
                                </div>
                                <div v-if="cartItem.item.color_stone" class="small">
                                    <span><strong>Цвет камня:</strong> {{cartItem.item.color_stone}}</span>
                                </div>
                            </div>
                        </figure>
                    </td>
                    <td class="price" data-th="Цена">{{cartItem.price/cartItem.qty}} р.</td>
                    <td data-th="Кол-во">
                        <a href="#" @click="reduceFromCart(key)"><i class="fal fa-minus"></i></a>
                        {{cartItem.qty}}
                        <a href="#" @click="addToCart(cartItem)"><i class="fal fa-plus"></i></a>
                    </td>
                    <td data-th="Итого" class="text-center">{{cartItem.price}} р.</td>
                    <td class=" text-center actions"><a @click="removeFromCart(key)" href="#"><i class="fal fa-times"></i></a></td>
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
                <div class="float-right">
                    <a href="/"  class="hidden-xs text-muted btn btn-link"><i
                            class="fa fa-angle-left"></i> Продолжить покупки</a>
                    <a :href="route"><button class="btn btn-dark " :disabled="!(cart.totalPrice >= minsum)">Оформить заказ <i class="fa fa-angle-right"></i></button></a>
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
                var query_options = {
                    option_id: item.option_id,
                    quantity: 1,
                };
                bus.$emit('added-to-cart', item.product_id, query_options)
            },

        }
    }
</script>
