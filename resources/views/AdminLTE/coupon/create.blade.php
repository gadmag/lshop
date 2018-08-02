@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">

                    <h1 class="heading">Форма создания</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($coupon = new \App\Coupon, ['url' => route('coupons.store'), 'class' => 'coupon']) !!}

                            @include('AdminLTE.coupon._form',['submitButtonText' => 'Добавить купон'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection