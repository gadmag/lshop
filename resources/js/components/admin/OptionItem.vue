<template>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <td>Артикул</td>
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
        <tr v-if="forms && forms.length > 0" v-for="(form, key) in forms" class="option-value-row">
            <td>
                <input type="hidden" :name="'productOptions['+key+'][id]'" v-model="form.id">
                <div class="form-group">
                    <input type="text" class="form-control" :name="'productOptions['+key+'][sku]'" v-model="form.sku"
                           placeholder="Артикул:">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control select2 color-select" :name="'productOptions['+key+'][color]'">
                        <option :value="null">Выбрать цвет</option>
                        <option :selected="color == form.color" v-for="color in colors" :value="color">{{color}}
                        </option>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control select2 color-select" :name="'productOptions['+key+'][color_stone]'">
                        <option :value="null">Выбрать камень</option>
                        <option :selected="stone == form.color_stone" v-for="stone in colors_stone" :value="stone">
                            {{stone}}
                        </option>
                    </select>
                </div>
            </td>
            <td>

                <image-upload :name="'productOptions['+key+'][optionUpload]'" :action="action"
                              :files="form.files"></image-upload>
            </td>
            <td>
                <div class="form-group">
                    <div><label>Цена</label></div>
                    <input class="form-control form-price" :name="'productOptions['+key+'][price]'" type="text"
                           v-model="form.price"
                           placeholder="Цена:">
                </div>
            </td>
            <td>

                    <input type="hidden" :name="'productOptions['+key+'][discount][id]'" v-model="form.discount.id">
                    <div class="form-group form-inline">
                        <label class="my-1 mr-2">Скидка:</label>
                        <input class="form-control form-price" :name="'productOptions['+key+'][discount][price]'"
                               type="text"
                               v-model="form.discount.price" placeholder="Цена:">
                    </div>
                    <div class="form-group form-inline">
                       <label class="my-1 mr-2">Кол-во:</label>
                        <input class="form-control form-qty" :name="'productOptions['+key+'][discount][quantity]'"
                               type="text" v-model="form.discount.quantity" placeholder="Кол-во:">
                    </div>

            </td>
            <td>
                <div class="form-group">
                    <input class="form-control form-weight" :name="'productOptions['+key+'][weight]'" type="text"
                           v-model="form.weight" placeholder="Вес:">
                </div>

            </td>
            <td>
                <div class="form-group">
                    <input :name="'productOptions['+key+'][quantity]'" type="text" class="form-control form-qty"
                           v-model="form.quantity" placeholder="Кол-во:">

                </div>
            </td>
            <td>
                <button v-if="form" :data-id="form.id" @click="removeOption(key)" type="button" data-toggle="tooltip"
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
            },
            old_options: {
                type: Array,
            },
            colors: {},
            colors_stone: {},
            action: ''
        },
        data() {
            return {
                forms: this.options.map(function (form) {
                    if (!form.discount) {
                        form.discount = {
                            id: '',
                            quantity: '',
                            price: ''
                        }
                    }
                    return form
                })
            }
        },

        mounted() {
            let old_options = this.old_options.filter(function (element) {
                return !element.id
            });

            this.forms = this.forms.concat(old_options);
           /* this.forms = this.forms.map(function (form) {
                if (!form.discount) {
                    form.discount = {
                        id: '',
                        quantity: '',
                        price: ''
                    }
                }
                return form
            });*/
            console.log('Component mounted.')
        },

        methods: {
            addOption() {
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
                } else {
                    this.forms.splice(key, 1)
                }
            }
        },

    }
</script>
