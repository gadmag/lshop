<template>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <td>Цвет покрытия: &nbsp;&nbsp;</td>
            <td>Цвет камня: &nbsp;&nbsp;</td>
            <td>Фото:</td>
            <td>Цена:</td>
            <td>Вес</td>
            <td>Кол-во</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <tr v-if="options && options.length > 0" v-for="(item, key) in forms" class="option-value-row">
            <td>
                <div class="form-group">
                    <input type="hidden" :name="'productOptions['+key+'][id]'" :value="item.id">
                    <select class="form-control" :name="'productOptions['+key+'][color]'">
                        <option :value="null">Выбрать</option>
                        <option :selected="color == item.color" v-for="color in colors" :value="color">{{color}}</option>
                    </select>
                </div>
            </td>

            <td>
                <div class="form-group">
                    <select class="form-control" :name="'productOptions['+key+'][color_stone]'">
                        <option :value="null">Выбрать</option>
                        <option :selected="stone == item.color_stone" v-for="stone in colors_stone" :value="stone">{{stone}}</option>
                    </select>
                </div>
            </td>
            <td>

                <div v-if="item.files" :id="'file-item-' + item.files.id" class="remove-file"
                :data-id="item.files.id"><span href="#"><i class="fa fa-remove fa-lg"></i></span><img class="thumbnail"
                :src="'/storage/files/thumbnail/' + item.files.filename"
                alt="Картинка">
                </div>

                <div class="form-group">
                      <label> Картинка товара</label>
                        <input class="form-control" type="file" :name="'productOptions['+key+'][image_option]'">
                    <p class="help-block">Выберите файл для добавления</p>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control" :name="'productOptions['+key+'][price_prefix]'">
                        <option :selected="prefix == item.price_prefix" v-for="prefix in prefixOptions" :value="prefix">{{prefix}}</option>
                    </select>
                    <input class="form-control" :name="'productOptions['+key+'][price]'" type="text" :value="item.price"
                           placeholder="Цена:">
                </div>
            </td>

            <td>
                <div class="form-group">
                    <select class="form-control" :name="'productOptions['+key+'][weight_prefix]'">
                        <option :selected="prefix == item.weight_prefix" v-for="prefix in prefixOptions" :value="prefix">{{prefix}}</option>
                    </select>
                    <input class="form-control" :name="'productOptions['+key+'][weight]'" type="text" :value="item.weight"
                           placeholder="Вес:">
                </div>

            </td>
            <td>
                <div class="form-group">
                    <input :name="'productOptions['+key+'][quantity]'" type="text" class="form-control"
                           :value="item? item.quantity: 1" placeholder="Кол-во:">

                </div>
            </td>
            <td>
                <button v-if="item" :data-id="item.id" @click="removeOption(key)" type="button" data-toggle="tooltip"
                        class="remove-options btn btn-danger"><i
                        class="fa fa-minus-circle"></i></button>
            </td>
        </tr>
        </tbody>

        <tfoot>
        <td colspan="6"></td>
        <td class="text-left">
            <button id="add-optionss" @click="addOption" data-type="coating" type="button" data-toggle="tooltip"
                    class="option-button btn btn-primary"><i
                    class="fa fa-plus-circle"></i></button>
        </td>
        </tfoot>
    </table>
</template>

<script>
    export default {
        props: {
            options:{
              type: Array,
              default: []
            } ,
            colors: {},
            colors_stone: {}
        },
        data() {
            return {
                prefixOptions: ['+', '-'],
                forms: this.options
            }
        },
        methods: {
            addOption() {
                this.forms.push({
                    id: '',
                    color: '',
                    color_stone: '',
                    image_option: '',
                    price: '',
                    weight: '',
                    price_prefix: '+',
                    weight_prefix: '+',
                    quantity: 1
                })
            },

            removeOption(key){
                if (this.forms[key].id) {
                    var url = "/admin/option/" + this.forms[key].id;

                    axios.get(url)
                        .then((res) => {
                            this.forms.splice(key,1)
                        })
                        .catch((error) => {
                            console.log(error)
                        })
                        .finally(() => {
                            // this.loading = false;
                        })

                } else {
                    this.forms.splice(key,1)
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
