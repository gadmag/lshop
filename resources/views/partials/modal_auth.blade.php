{{--<!-- Modal -->--}}
{{--<div class="modal fade" id="modal-auth" tabindex="-1" role="dialog" aria-labelledby="authModalLabel"--}}
{{--     aria-hidden="true">--}}
{{--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--        <span aria-hidden="true"></span>--}}
{{--    </button>--}}
{{--    <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--        <div class="modal-content">--}}

{{--            <div class="modal-header">--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span class="fal fa-times"></span>--}}
{{--                </button>--}}
{{--                <h4 class="mx-auto title-head py-2" id="authModalLabel"><b>Авторизация</b></h4>--}}
{{--            </div>--}}
{{--            <div class="modal-body bg-white social-body">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-9 mx-auto">--}}
{{--                        <div class="text-center pb-2">Войдите через аккаунт в соцсети — это проще всего:</div>--}}
{{--                        @include('partials.social_auth')--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="modal-body bg-light email-body">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-9 mx-auto">--}}
{{--                        <div class="text-muted pb-3 text-center">Авторизация по email</div>--}}
{{--                        <div class="form-content">--}}
{{--                            <div class="col-md-8 mx-auto" id="message"></div>--}}
{{--                            <form id="auth-form" method="POST" action="{{ route('apiLogin') }}">--}}
{{--                                @csrf--}}

{{--                                <div class="form-group">--}}
{{--                                    <input id="email" type="email"--}}
{{--                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"--}}
{{--                                           name="name"--}}
{{--                                           placeholder="Email" value="{{ old('email') }}" required--}}
{{--                                           autofocus>--}}


{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                     @if ($errors->has('email'))--}}
{{--                                            <strong>{{ $errors->first('email') }}</strong>--}}
{{--                                        @endif--}}
{{--                                    </span>--}}
{{--                                </div>--}}

{{--                                <div class="form-group">--}}
{{--                                    <input id="password" type="password"--}}
{{--                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"--}}
{{--                                           placeholder="Пароль" name="password" required>--}}

{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                     @if ($errors->has('password'))--}}
{{--                                            <strong>{{ $errors->first('password') }}</strong>--}}
{{--                                        @endif--}}
{{--                                    </span>--}}

{{--                                    <div class="text-right">--}}
{{--                                        <a class="forgot-password pt-1 text-muted" href="{{ route('password.request') }}">Забыли--}}
{{--                                            пароль?</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="form-group">--}}

{{--                                    <div class="custom-control remember-control custom-checkbox">--}}
{{--                                        <input class="custom-control-input" type="checkbox" name="remember"--}}
{{--                                               id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
{{--                                        <label class="custom-control-label" for="remember">Запомнить</label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}

{{--                                    <button type="submit" class="btn w-100 d-block btn-dark">--}}
{{--                                        Войти--}}
{{--                                    </button>--}}
{{--                                    <div class="my-3 text-center"><a href="{{route('register')}}"--}}
{{--                                                                     class="text-muted">Регистрация по email</a>--}}
{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


