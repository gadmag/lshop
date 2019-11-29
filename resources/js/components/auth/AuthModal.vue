<template>
    <div>
        <!-- Modal -->
        <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#modal-auth">
            Войти
        </button>
        <div class="modal fade" id="modal-auth" tabindex="-1" role="dialog" aria-labelledby="authModalLabel"
             aria-hidden="true">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <keep-alive>
                        <component :recaptcha-key="recaptchaKey" v-bind:is="authComponent"></component>
                    </keep-alive>

                </div>
            </div>
        </div>
    </div>


</template>

<script>

    import LoginForm from '../auth/LoginForm';
    import RegisterForm from '../auth/RegisterForm';

    export default {
        props: ['recaptchaKey'],
        data: function () {
            return {
                authComponent: 'login-form',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        components: {
            'login-form': LoginForm,
            'register-form': RegisterForm,
        },
        created() {
            bus.$on('select-component', (component) => {
                this.authComponent = component;
            })
        },
        methods: {

        }
    }
</script>
