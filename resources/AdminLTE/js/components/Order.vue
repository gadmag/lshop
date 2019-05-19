<template>
    <div class="orders-form">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td>Наименование товара &nbsp;&nbsp;</td>
                <td>Кол-во: &nbsp;&nbsp;</td>
                <th class="text-right">Цена за шт</th>
                <th class="text-right">Всего</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="cart.items && cart.items.length > 0" v-for="(item, key) in forms" class="option-value-row">
                <td><input type="hidden" :name="'productOptions['+key+'][id]'" :value="item.product_id">{{item.item['title']}}
                </td>
                <td style="max-width: 60px">
                    <div class="input-group">
                        <input type="text" class="form-control" name="quantity" :value="item['qty']">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-primary" data-toggle="tooltip"
                                data-original-title="Обновить"><i class="fa fa-refresh"></i></button>
                    </span>
                    </div>
                </td>
                <td class="text-right">{{item['price']/item['qty']}} р.</td>
                <td class="text-right">{{item['price']}} р.</td>
                <td>
                    <button v-if="item" :data-id="item.id" @click="removeOption(key)" type="button"
                            data-toggle="tooltip"
                            class="remove-options btn btn-danger"><i
                            class="fa fa-minus-circle"></i></button>
                </td>
            </tr>
            </tbody>

            <tfoot>
            </tfoot>
        </table>
        <fieldset>
            <legend>Добавить товары</legend>
            <div class="form-group">
                <label for="keywords">Выбрать товар</label>
                <div class="dropdown">
                    <input id="keywords" type="text"  @focus="dropdownToggle = true" @blur="" v-model="keywords"  class="form-control">
                    <ul class="dropdown-menu" :class="{active: dropdownToggle }" v-if="results && results.length > 0">
                        <li v-for="result in results" :key="result.id"><span @click="selectTitle(result)" v-html="highlight(result.title)"></span></li>
                    </ul>
                </div>
                <input type="hidden" name="product_id">
            </div>
            <div class="options">
                <fieldset>
                    <legend>Выбор опции</legend>
                    <div class="form-group">
                        <label>Выбрать опцию</label>
                        <select class="form-control" id="select-option">
                            <option value=""></option>
                        </select>
                    </div>

                </fieldset>
            </div>
        </fieldset>
        <div class="text-right">
<!--            <button id="add-optionss" @click="addOption" data-type="coating" type="button" data-toggle="tooltip"-->
<!--                    class="option-button btn btn-primary"><i-->
<!--                    class="fa fa-plus-circle"></i> Добавить продукт-->
<!--            </button>-->
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            cart: {
                type: Object,
                default: []
            },
            products: null,

        },
        data() {
            return {
                forms: this.cart.items,
                keywords: null,
                results: this.products,
                dropdownToggle: false
            }
        },
        watch: {
            keywords(after, before) {
                let _this = this;
                this.throttledMethod(_this);
            }
        },
        methods: {
            fetch() {
                axios.get('/admin/api/orders', {params: {keywords: this.keywords}})
                    .then(response => {
                        this.results = response.data;
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },

            removeOption(key) {
                if (this.forms[key].id) {
                    var url = "/admin/option/" + this.forms[key].id;

                    axios.get(url)
                        .then((res) => {
                            this.forms.splice(key, 1)
                        })
                        .catch((error) => {
                            console.log(error)
                        })
                        .finally(() => {
                            // this.loading = false;
                        })

                } else {
                    this.forms.splice(key, 1)
                }
            },

            selectTitle(product){
                console.log(product.title);
                this.keywords = product.title;
                this.dropdownToggle = false;
            },
            highlight(text) {
                return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>');
            },

            throttledMethod: _.debounce((_this) => {
                _this.fetch();
            }, 300)
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
