<template>
    <div class="cart-detail">
        <div v-if="carttotal > 0" class="">
            <div class="table-responsive">
                <table class="table table-detail table-hover">
                    <thead>
                    <tr class="hidden-xs">
                        <th class="img-cart">Фото</th>
                        <th>Наименование</th>
                        <th class="price-cart">Цена</th>
                        <th>Кол-во</th>
                        <th>Итого</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(cartItem, key, index) in cart.items">
                        <td class="img-cart"><img v-if="cartItem.item.files[0]" class="img-responsive"
                                                  :src="'/storage/files/90x110/'+cartItem.item.files[0].filename"
                                                  alt="Картинка товара"></td>
                        <td>{{cartItem.item.title}}</td>
                        <td class="price-cart">{{cartItem.price/cartItem.qty}} р.</td>
                        <td class="cart-qty">
                            <div>
                                <span @click="reduceFromCart(key)" type="button"><i class="fa fa-minus"></i> </span>  <b>{{cartItem.qty}}</b>
                                <span @click="addToCart(cartItem)" type="button"> <i class="fa fa-plus"></i></span>
                            </div>
                        </td>
                        <td class="price-sum">{{cartItem.price}} р.</td>
                        <td class="text-center"><a @click="removeFromCart(key)" href="#"><i class="fa fa-remove"></i></a></td>
                    </tr>
                    <tr>

                    </tr>
                    </tbody>
                </table>
                <div class="cart-detail-bottom">
                    <div class="button-cart"><a href="/shopping-cart" class="btn lotus-button">Просмотр корзины</a></div>
                    <div class="total-cart"><strong>Итого: {{cart.totalPrice}} р.</strong></div>
                </div>

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
               var query_options = {
                    option_id: item.option_id,
                    quantity: 1,
                };
                bus.$emit('added-to-cart', item.product_id, query_options)
            }
        }
    }
</script>
