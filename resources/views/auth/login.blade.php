@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="w-100 text-center"><h2 class="py-3 text-uppercase">Авторизация</h2></div>
        <div class="row justify-content-center">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <form role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <input id="email" type="email" class="form-control" name="email"
                               value="{{ old('email') }}" placeholder="Почта">

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <input id="password" type="password" class="form-control"
                               placeholder="Пароль" name="password">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                        @endif
                        <div class="text-right">
                            <a class="btn btn-link" href="{{ url('user/password/reset') }}">
                                Забыли пароль?
                            </a>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="custom-control text-left remember-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   name="remember" id="remember_login" {{ old('remember') ? 'checked' : ''}}>
                            <label class="custom-control-label" for="remember_login">Запомнить</label>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn w-100 btn-dark">Войти</button>
                        <a class="btn btn-link" href="{{url('user/register')}}">Регистрация по email.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
