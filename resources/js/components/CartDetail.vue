<template>
    <div class="cart-detail">
        <div v-if="carttotal > 0" class="">
            <table class="table table-detail table-hover">
                <thead class="thead-light">
                <tr>
                    <th colspan="4" scope="col"><b>В корзине {{qtyNameSuffix}}</b></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(cartItem, key, index) in cart.content">
                    <td class="title">
                        <figure class="media">
                            <div class="mr-2 d-none d-sm-block img-wrap">
                                <img v-if="cartItem.image"
                                     :src="'/storage/files/90x110/'+cartItem.image" class="" alt="Фото товара">
                            </div>
                            <div class="media-body">
                                <figcaption>{{cartItem.name}}</figcaption>
                                <div v-if="cartItem.options.color" class="small">
                                    <span><strong>Цвет:</strong> {{cartItem.options.color}}</span>
                                </div>
                                <div v-if="cartItem.options.color_stone" class="small">
                                    <span><strong>Цвет камня:</strong> {{cartItem.options.color_stone}}</span>
                                </div>
                                <div v-if="cartItem.engravings" class=" small">
                                    <a class="btn-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Гравировка
                                    </a>
                                    <ul class="dropdown-menu list-unstyled" aria-labelledby="dropdownMenuLink">
                                        <li  v-for="engraving in cartItem.engravings">
                                           <span>{{engraving.title}}</span> <span>{{engraving.price}} р.</span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </figure>
                    </td>
                    <td class="cart-qty">
                        <div>
                            <span @click="reduceFromCart(key)">-</span> {{cartItem.qty}}
                            <span @click="addToCart(cartItem)">+</span>
                        </div>
                    </td>
                    <td class="price-sum">{{cartItem.price.toFixed(2)}} р.</td>
                    <td class="remove text-center"><span @click="removeFromCart(key)"><i
                            class="fa fa-times"></i></span></td>
                </tr>
                </tbody>
            </table>
            <div class="p-2 cart-detail-bottom">
                <hr>
                <div class="float-left button-cart"><a href="/shopping-cart" class="btn btn-dark">Корзина</a></div>
                <div class="float-right pt-1 total-cart">Итого: {{cart.totalPrice.toFixed(2)}} р.</div>
            </div>
        </div>
        <div class="empty-cart" v-else>
            <div class="py-2 text-center"><span class="align-middle">Корзина пуста</span></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['cart', 'carttotal'],
        mounted() {
            console.log('Component Cart detail mounted.');


        },
        created() {
            console.log(this.cart);
        },
        computed: {
            qtyNameSuffix() {
                let str = '';
                if (this.cart.totalQty && this.cart.totalQty > 0) {
                    switch (this.cart.totalQty) {
                        case 1:
                            str = this.cart.totalQty + ' товар';
                            break;
                        case 2:
                            str = this.cart.totalQty + ' товара';
                            break;
                        case 3:
                            str = this.cart.totalQty + ' товара';
                            break;
                        case 4:
                            str = this.cart.totalQty + ' товара';
                            break;
                        default:
                            str = this.cart.totalQty + ' товаров';
                    }
                    return str;
                }
                return '';
            }
        },

        methods: {
            removeFromCart(id) {
                bus.$emit('remove-from-cart', id)
            },

            reduceFromCart(key) {
                bus.$emit('reduce-from-cart', key)
            },

            addToCart(item) {
                let options = {
                    id: item.options.id,
                    quantity: 1,
                };
                bus.$emit('added-to-cart', item.id, options)
            }
        }
    }
</script>
