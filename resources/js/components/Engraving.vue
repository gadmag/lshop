<template>
    <div class="modal modal-site fade" id="engravingModal" tabindex="-1" aria-labelledby="engravingModalLable" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="engravingModalLable">Добавить гравировку</h5>
                    <button @click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="services && services.length > 0" class="engraving-block">

                        <div class="form-group">
                            <select class="form-control" v-model="engraving.id">
                                <option disabled value="">Выбрать тип гравировки</option>
                                <option v-for="service in services" :value="service.id">
                                    {{service.title}}<template v-if="service.price > 0"> ({{service.price}} р.)</template>
                                </option>
                            </select>
                        </div>
                        <div v-if="name===`order`" class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-ruble-sign"></i></span>
                            </div>
                            <input id="engravingPrice" class="form-control" type="number" v-model="engraving.price">
                        </div>
                        <div class="form-group">
                            <select class="form-control" v-model="engraving.font">
                                <option disabled value="">Выбрать шрифт</option>
                                <option v-for="font in fonts" :value="font.title">{{font.title}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="engravingText">Текст гравировки:</label>
                            <textarea v-model="engraving.text" id="engravingText" rows="3" class="form-control"
                                      :class="{'is-invalid': errors && errors['options.engraving.text']}"></textarea>
                            <span v-if="errors && errors['options.engraving.text']" class="invalid-feedback"
                                  role="alert">Поле Текст гравировки обязательно для заполнения, если не выбран файл.</span>
                        </div>
                        <div class="form-group">
                            <image-upload @getFiles="getFileName($event)"
                                          name="engravingUpload" :box-input="false"
                                          :allow-multiple="false" action="/uploadFiles"></image-upload>

                        </div>
                        <div class="form-group">
                            <label for="engravingComment">Комментарий:</label>
                            <textarea v-model="engraving.comment" class="form-control" id="engravingComment" rows="3"></textarea>
                        </div>
                        <div class="quantity form-group">
                            <label for="qty">Кол-во</label>
                            <input type="number" v-model="engraving.qty" name="qty" id="qty"
                                   class="form-control">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="close" class="btn btn-outline-dark" data-dismiss="modal">Закрыть</button>
                    <button type="button" @click="addEngraving()" class="btn btn-dark">Добавить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Engraving",
        props: {
            name: '',
            services: '',
            cartKey: '',
            order_id: '',
            fonts: '',
            data: ''
        },
        data: function () {
            return {
                // services: this.servicesList,
                engraving: {
                    id: '',
                    price: '',
                    text: '',
                    font: '',
                    comment: '',
                    filename: '',
                    qty: 1
                },
                errors: '',
                message: ''
            }
        },
        methods: {
            getFileName(filename) {
                this.engraving.filename = filename[0];
            },

            addEngraving() {
                let url = '/api/add-engraving/' + this.cartKey;
                let params = {options: JSON.stringify({engraving: this.engraving}), order_id: this.order_id};
                console.log(params);
                axios.get(url,{params: params})
                    .then(function (response) {
                        this.errors = '';
                        this.message = '';
                        if (response.data.errors) {
                            return this.errors = response.data.errors;
                        }
                        if (response.data.message) {
                            return this.message = response.data.message;
                        }

                        if (response.data.cart) {
                            this.$emit('getCart',response.data.cart);
                            bus.$emit('engraving-from-cart', response.data);
                        }

                    }.bind(this))
                    .catch(function (error) {
                        this.message = null;
                        let status = error.response.status;
                        this.errors = error.response.data.errors;
                        this.message = this.getErrorMessage(status);
                    }.bind(this));
            },

            close() {
                // this.services = '';
                this.engraving.id = '';
                this.engraving.text = '';
            }
        }
    }
</script>

<style scoped>

</style>