<template>
    <div>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fal fa-times"></span>
            </button>
            <h4 class="mx-auto title-head py-2" id="authModalLabel"><b>Авторизация</b></h4>
        </div>
        <div class="modal-body bg-white social-body">
            <div class="row">
                <div class="col-9 mx-auto">
                    <!--                                <div class="text-center pb-2">Войдите через аккаунт в соцсети — это проще всего:</div>-->
                    <!--                                @include('partials.social_auth')-->
                </div>
            </div>
        </div>
        <div class="modal-body bg-light email-body">
            <div class="row">
                <div class="col-9 mx-auto">
                    <div class="text-muted pb-3 text-center">Авторизация по email</div>
                    <div class="form-content">
                        <form id="auth-form" method="POST" :action="actionLogin">
                            <div class="form-group">
                                <input id="email" type="email"
                                       class="form-control"
                                       name="name"
                                       placeholder="Email" v-model="email" required
                                       :class="{'is-invalid': errors && errors.email}"
                                       autofocus>
                                <span v-if="errors && errors.email" class="invalid-feedback" role="alert">{{errors.email[0]}}</span>
                            </div>

                            <div class="form-group">
                                <input id="password" type="password"
                                       class="form-control" placeholder="Пароль"
                                       name="password" v-model="password"
                                       :class="{'is-invalid': errors && errors.password}"
                                       required>

                                <span v-if="errors && errors.password" class="invalid-feedback"
                                      role="alert">{{errors.password[0]}}</span>

                                <div class="text-right">
                                    <a class="forgot-password pt-1 text-muted" href="">Забыли пароль?</a>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control text-left remember-control custom-checkbox">
                                    <input v-model="remember" class="custom-control-input" type="checkbox"
                                           name="remember"
                                           id="remember">
                                    <label class="custom-control-label" for="remember">Запомнить</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text-center text-danger py-2" id="message" role="alert">{{message}}</div>
                                <button type="submit" @click.stop.prevent="fetchLogin()"
                                        class="btn w-100 d-block btn-dark">
                                    Войти
                                </button>
                                <div class="my-3 text-center"><a href="#" @click.stop.prevent="selectRegister"
                                                                 class="text-muted">Регистрация по email</a>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['oldEmail', 'oldPass'],

        data: function () {
            return {
                actionLogin: '/api/user/login',
                errors: null,
                message: null,
                email: this.oldEmail ? this.oldEmail : null,
                password: this.oldPass ? this.oldPass : null,
                remember: false
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        methods: {

            selectRegister() {
                bus.$emit('select-component', 'register-form');
            },

            fetchLogin() {
                axios.post(this.actionLogin, {
                    email: this.email,
                    password: this.password,
                    remember: this.remember,
                })
                    .then(function (response) {
                        console.log(response);
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
