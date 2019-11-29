<template>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <td>Цвет покрытия: &nbsp;&nbsp;</td>
            <td>Цвет камня: &nbsp;&nbsp;</td>
            <td>Фото:</td>
            <td>Цена:</td>
            <td>Скидки</td>
            <td>Вес</td>
            <td>Кол-во</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <tr v-if="forms && forms.length > 0" v-for="(item, key) in forms" class="option-value-row">
            <td>
                <div class="form-group">
                    <input type="hidden" :name="'productOptions['+key+'][id]'" :value="item.id">
                    <select class="form-control" :name="'productOptions['+key+'][color]'">
                        <option :value="null">Выбрать</option>
                        <option :selected="color == item.color" v-for="color in colors" :value="color">{{color}}
                        </option>
                    </select>
                </div>
            </td>

            <td>
                <div class="form-group">
                    <select class="form-control" :name="'productOptions['+key+'][color_stone]'">
                        <option :value="null">Выбрать</option>
                        <option :selected="stone == item.color_stone" v-for="stone in colors_stone" :value="stone">
                            {{stone}}
                        </option>
                    </select>
                </div>
            </td>
            <td>
                <ul class="list-inline" v-if="item.files && item.files.length">
                    <li v-for="file in item.files" :id="'file-item-' + file.id" class="remove-file"
                        :data-id="file.id"><span href="#"><i class="fa fa-remove fa-lg"></i></span>
                        <img class="thumbnail" :src="'/storage/files/thumbnail/' + file.filename" alt="Картинка">
                    </li>
                </ul>
                <div class="clearfix"></div>

                <div class="input-group">
                    <label>Фото товара</label>
                    <input type="file" :name="'productOptions['+key+'][image_option]'" multiple>
                    <p class="help-block">Выберите файл для добавления</p>
                </div>

            </td>
            <td>
                <div class="form-group">

                    <input class="form-control form-price" :name="'productOptions['+key+'][price]'" type="text"
                           :value="item.price"
                           placeholder="Цена:">
                </div>
            </td>
            <td>
                <div class="form-inline">
                    <input type="hidden" :name="'productOptions['+key+'][discount][id]'" :value="item.discount?item.discount.id:null">
                    <div class="form-group">
                        <div><label>Цена</label></div>
                        <input class="form-control form-price" :name="'productOptions['+key+'][discount][price]'"
                               type="text"
                               :value="item.discount?item.discount.price:null" placeholder="Цена:">
                    </div>
                    <div class="form-group">

                        <div><label>Кол-во:</label></div>
                        <input class="form-control form-qty" :name="'productOptions['+key+'][discount][quantity]'"
                               type="text"
                               :value="item.discount?item.discount.quantity:null" placeholder="Кол-во:">
                    </div>

                </div>
            </td>
            <td>
                <div class="form-group">
                    <input class="form-control form-weight" :name="'productOptions['+key+'][weight]'" type="text"
                           :value="item.weight"
                           placeholder="Вес:">
                </div>

            </td>
            <td>
                <div class="form-group">
                    <input :name="'productOptions['+key+'][quantity]'" type="text" class="form-control form-qty"
                           :value="item? item.quantity: 1" placeholder="Кол-во:">

                </div>
            </td>
            <td>
                <button v-if="item" :data-id="item.id" @click="removeOption(key)" type="button" data-toggle="tooltip"
                        class="remove-options btn btn-danger"><i class="fa fa-minus-circle"></i></button>
            </td>
        </tr>
        </tbody>

        <tfoot>
        <td colspan="7"></td>
        <td class="text-center">
            <button id="add-optionss" @click="addOption" data-type="coating" type="button" data-toggle="tooltip"
                    class="option-button btn btn-primary"><i class="fa fa-plus-circle"></i></button>
        </td>
        </tfoot>
    </table>
</template>

<script>
    export default {
        props: {
            options: {
                type: Array,
                // default: []
            },
            old_options:{
                type: Array,
                // default: []
            },
            colors: {},
            colors_stone: {}
        },
        data() {
            return {
                forms: this.options
            }
        },

        mounted() {
            this.forms = this.forms.concat(this.old_options);
            console.log('Component mounted.')
        },

        methods: {
            addOption() {
                console.log('push');
                this.forms.push({
                    id: '',
                    color: '',
                    color_stone: '',
                    image_option: '',
                    price: '',
                    discount: {
                        id: '',
                        quantity: '',
                        price: ''
                    },
                    weight: '',
                    quantity: 1
                })
            },

            removeOption(key) {
                if (this.forms[key].id) {
                    var url = "/admin/option/" + this.forms[key].id;
                    this.forms.splice(key, 1);
                    /* axios.get(url)
                         .then((res) => {
                             this.forms.splice(key, 1)
                         })
                         .catch((error) => {
                             console.log(error)
                         })
                         .finally(() => {
                             // this.loading = false;
                         })
                     */
                } else {
                    this.forms.splice(key, 1)
                }
            }
        },

    }
</script>
