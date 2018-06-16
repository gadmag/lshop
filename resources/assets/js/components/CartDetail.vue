<template>

    <div v-if="carttotal > 0" class="container">
        <div class="row">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>id:</th>
                    <th>Наименование:</th>
                    <th>Кол-во</th>
                    <th>Цена:</th>
                    <th>Итого</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="cartItem in cart.items">
                    <td>{{cartItem.item.id}}</td>
                    <td>{{cartItem.item.title}}</td>
                    <td width="100px">
                        <button @click="removeFromCart(cartItem.item)" class="button alert tiny">-</button>
                        <strong>{{cartItem.qty}}</strong>
                        <button @click="addToCart(cartItem.item)" class="button success tiny">+</button>
                    </td>
                    <td>{{cartItem.price}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        {{cart.totalPrice}}
                    </td>
                </tr>
                <div>{{carttotal}}</div>
                </tbody>
            </table>
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
            addToCart(item) {
                bus.$emit('added-to-cart', item)
            }
        }
    }
</script>
