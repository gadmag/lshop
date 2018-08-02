@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">
                    <h1 class="heading">Редактировать: {{$coupon->title}}</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($coupon, ['method' => 'PATCH', 'action' => ['Admin\CouponController@update', $coupon->id], 'class' => 'coupon']) !!}

                            @include('AdminLTE.coupon._form',['submitButtonText' => 'Сохранить купон'])
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection