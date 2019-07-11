@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="panel-heading text-center py-4"><h1 class="title">Регистрация</h1></div>
        <div class="row justify-content-center">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <input id="name" type="text" class="form-control"
                               name="name" value="{{ old('name') }}" placeholder="Имя"
                               autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">

                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                               placeholder="Почта">

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <input id="password" type="password" class="form-control"
                               name="password" placeholder="Пароль">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' is-invalid' : '' }}">
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" placeholder="Подтвердите пароль">
                    </div>
                    @push('recaptcha_script')
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    @endpush

                    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' is-invalid' : '' }}">
                        <div class="g-recaptcha" data-sitekey="{{config('payment.recaptcha_key')}}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="invalid-feedback">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="w-100 btn btn-dark">Регистрация</button>
                    </div>
                    <div class="form-group">
                        <div class="custom-control text-left custom-checkbox">
                            <input v-model="privacy_policy"
                                   class="custom-control-input{{ $errors->has('privacy_policy') ? ' is-invalid' : '' }}"
                                   type="checkbox"
                                   name="privacy_policy" id="privacy_policy">
                            <label class="custom-control-label text-muted" for="privacy_policy">
                                Я принимаю пользовательское <a href="#">соглашение</a> и <a href="#">политику</a>
                                обработки персональных данных.
                            </label>
                            @if ($errors->has('privacy_policy'))
                                <span class="invalid-feedback">{{ $errors->first('privacy_policy') }}</span>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
