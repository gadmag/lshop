<template>
    <div class="shipment-field">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Указать вес и цену доставки</h3>
                <div class="box-tools pull-right">
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div v-if="shipments" v-for="(item, key) in forms" class="row">

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="price">Цена:</label>
                            <input id="price" class="form-control form-weight" :name="'price_setting['+key+'][price]'"
                                   type="text"
                                   :value="item.price">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="weight">Вес:</label>
                            <input id="weight" :name="'price_setting['+key+'][weight]'" type="text"
                                   class="form-control form-qty"
                                   :value="item.weight">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button v-if="item" :data-id="item.id" @click="removeOption(key)" type="button"
                                data-toggle="tooltip"
                                class="remove-shipments btn btn-danger"><i
                                class="fa fa-minus-circle"></i></button>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-2 pull-right">
                        <button id="add-shipments" @click="addOption" data-type="coating" type="button"
                                data-toggle="tooltip"
                                class="shipment-button btn btn-primary"><i
                                class="fa fa-plus-circle"></i></button>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</template>

<script>
    export default {
        props: {
            shipments: {
                type: Array,
                default: []
            },
        },
        data() {
            return {
                forms: this.shipments
            }
        },

        created: function () {
            // this.forms = this.shipments;
        },

        methods: {
            addOption() {
                this.forms.push({
                    price: '',
                    weight: '',
                })
            },

            removeOption(key) {
                if (this.forms[key]) {
                    this.forms.splice(key, 1);
                    console.log(this.forms);
                }
                // if (this.forms.length == 0) {
                //     this.forms = [];
                //     console.log(this.forms);
                // }
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
