<template>
    <div>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fal fa-times"></span>
            </button>
            <h4 class="w-100 text-center title-head py-2" id="authModalLabel">
                <a class="auth-tab-link" href="#" @click.stop.prevent="selectLogin"><i
                        class="far fa-arrow-left"></i></a>
                <b>Регистрация</b>
            </h4>
        </div>
        <!--        <div class="px-1 col-9 mx-auto auth-tab-link">-->
        <!--            -->
        <!--        </div>-->
        <div class="modal-body">
            <div class="row">
                <div class="col-9 mx-auto">
                    <form role="form" method="POST" :action="actionRegister">
                        <div class="form-group">
                            <input id="name" type="text" v-model="name"
                                   class="form-control" name="name" placeholder="Имя"
                                   :class="{'is-invalid': errors && errors.name}">
                            <span v-if="errors && errors.name" class="invalid-feedback"
                                  role="alert">{{errors.name[0]}}</span>
                        </div>

                        <div class="form-group">
                            <input id="email" type="email" v-model="email"
                                   class="form-control" name="email" placeholder="Почта"
                                   :class="{'is-invalid': errors && errors.email}">
                            <span v-if="errors && errors.email" class="invalid-feedback" role="alert">{{errors.email[0]}}</span>

                        </div>

                        <div class=" form-group">
                            <input id="password" type="password" v-model="password"
                                   class="form-control" name="password" placeholder="Пароль"
                                   :class="{'is-invalid': errors && errors.password}">
                            <span v-if="errors && errors.password" class="invalid-feedback" role="alert">{{errors.password[0]}}</span>
                        </div>

                        <div class="form-group">
                            <input id="password-confirm" type="password" v-model="password_confirmation"
                                   class="form-control" name="password_confirmation" placeholder="Подтвердить пароль"
                                   :class="{'is-invalid': errors && errors.password_confirmation}">
                            <span v-if="errors && errors.password_confirmation" class="invalid-feedback" role="alert">
                                {{errors.password_confirmation[0]}}
                            </span>
                        </div>

                        <div class="form-group" :class="{'is-invalid': errors && errors['g-recaptcha-response']}">
                            <vue-recaptcha :sitekey="recaptchaKey" @verify="register" :loadRecaptchaScript="true"></vue-recaptcha>
                            <span v-if="errors && errors['g-recaptcha-response']" class="invalid-feedback" role="alert">
                                {{errors['g-recaptcha-response'][0]}}
                            </span>
                        </div>
                        <div class="form-group">
                            <div class="text-center text-danger py-2" id="message" role="alert">{{message}}</div>
                            <button type="submit" @click.stop.prevent="fetchRegister" class="w-100 btn btn-dark">
                                Регистрация
                            </button>
                        </div>

                        <div class="form-group">
                            <div class="custom-control text-left remember-control custom-checkbox">
                                <input v-model="privacy_policy" class="custom-control-input" type="checkbox"
                                       name="privacy_policy" id="privacy_policy"
                                       :class="{'is-invalid': errors && errors.privacy_policy}">
                                <label class="custom-control-label text-muted" for="privacy_policy">
                                    Я принимаю пользовательское <a href="#">соглашение</a> и <a href="#">политику</a>
                                    обработки персональных данных.
                                </label>
                                <span v-if="errors && errors.privacy_policy" class="invalid-feedback" role="alert">
                                {{errors.privacy_policy[0]}}
                            </span>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import VueRecaptcha from 'vue-recaptcha';

    export default {
        name: "RegisterForm.vue",
        props: ['recaptchaKey'],
        data: function () {
            return {
                actionRegister: '/api/user/register',
                errors: null,
                message: null,
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
                recaptchaToken: false,
                privacy_policy: false,
            }
        },

        components: {
            'vue-recaptcha': VueRecaptcha
        },

        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            selectLogin() {
                bus.$emit('select-component', 'login-form');
            },

            register(recaptchaToken){
                this.recaptchaToken = recaptchaToken;
            },
            fetchRegister() {
                axios.post(this.actionRegister, {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    privacy_policy: this.privacy_policy,
                    'g-recaptcha-response': this.recaptchaToken,
                })
                    .then(function (response) {
                        this.errors = null;
                        this.message = null;
                        if (response.data.errors) {
                            return this.errors = response.data.errors;
                        }
                        if (response.data.message) {
                            return this.message = response.data.message;
                        }
                        if (response.data.redirect) {
                            window.location.href = response.data.redirect;
                        }
                    }.bind(this))

                    .catch(function (error) {
                        this.message = null;
                        let status = error.response.status;
                        this.errors = error.response.data.errors;
                        this.message = this.getErrorMessage(status);
                    }.bind(this));
            },

            getErrorMessage(status) {
                let message = '';
                switch (status) {
                    case 419:
                        message = 'Срок действия страницы истек из-за неактивности. Пожалуйста, обновите и попробуйте снова.';
                        break;
                }
                return message;
            }
        },
    }
</script>
<style scoped>

</style>