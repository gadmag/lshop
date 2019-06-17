<template>
    <div v-if="options" class="options-block">
        <div v-if="options && options.length > 0" class="form-group">
            <label for="dropdownOptions">Выбор цвета: </label>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" id="dropdownOptions" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">{{titleOption}}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownSortHeader">
                    <button :disabled="option.quantity <= 0" @click="selectOption(option)"
                            v-for="(option) in options"
                            :data-id="option.id" class="dropdown-item"
                            type="button">{{fullOptionName(option)}}
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['product','options'],
        data: function () {
            return {
                className: '',
                files: [],
                checkedNames: [],
                titleOption: this.fullOptionName(this.options[0])

            }
        },
        mounted() {
            this.allImagesProduct();
            console.log('Component mounted.');

        },
        methods: {
            selectOption(option) {
                const id = option.id;
                this.titleOption = this.fullOptionName(option);
                this.files.forEach(function (file, i, arr) {
                    if (file.uploadstable_id == id) {
                        let element = file;
                        arr.splice(i, 1);
                        arr.splice(0, 0, element);
                    }
                });
                this.$root.$emit('select-option', option);
            },
            getOptionByID(id) {
                let option = false;
                this.options.forEach(function (item, i) {
                    if (id === item.id) {
                        option = item;
                    }
                });
                return option;
            },

            fullOptionName(option) {
                let optionFullName = '';
                if (option.color) {
                    optionFullName = "Цвет: " + option.color
                }
                if (option.color_stone) {
                    let separator = optionFullName ? optionFullName + '/' : '';
                    optionFullName = separator + "Цвет камня: " + option.color_stone
                }
                return optionFullName
            },

            allImagesProduct() {
                let _this = this;
                this.files = this.product.files ? this.product.files : [];
                if (!this.product.product_options) {
                    return this.files
                }
                this.options.forEach(function (item, i) {
                    if (item.files != undefined && item.files != null) {
                        item.files.forEach(function (file) {
                            _this.files.push(file);
                        })
                    }
                });

                return this.files;
            }

        },

        computed: {

        }
    }
</script>
