<template>
    <div class="shopping-cart">
        <div v-if="carttotal > 0" class="">
            <div class="table-responsive">
                <table class="table table-shopping-cart table-hover">
                    <thead>
                    <tr>
                        <th class="img-cart">Фото</th>
                        <th>Наименование</th>
                        <th class="price">Цена</th>
                        <th>Кол-во</th>
                        <th>Итого</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(cartItem, key, index) in cart.items">
                        <!--<td>{{cartItem.item.id}}</td>-->

                        <td class="img-cart"><img v-if="cartItem.item.files[0]" class="img-responsive"
                                                  :src="'/storage/files/90x110/'+cartItem.item.files[0].filename"
                                                  alt="Картинка товара"></td>
                        <td>{{cartItem.item.title}}</td>
                        <td class="price">{{cartItem.price/cartItem.qty}} р.</td>
                        <td>
                            <a href="#" @click="reduceFromCart(key)" type="button"><i
                                    class="fa fa-minus"></i></a>
                            <strong>{{cartItem.qty}}</strong>
                            <a href="#" @click="addToCart(key)" type="button"><i
                                    class="fa fa-plus"></i></a>
                        </td>
                        <td>{{cartItem.price}} р.</td>
                        <td><a @click="removeFromCart(key)" href="#"><i class="fa fa-remove"></i></a></td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-right"><strong>Итого: {{cart.totalPrice}} р.</strong></div>
                <hr>
            </div>
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
