@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title',"Редактировать: {$coupon->title}")
<div class="coupons">
    <div class="article-body">
        @include('errors.list')
        {!! Form::model($coupon, ['method' => 'PATCH', 'action' => ['Admin\CouponController@update', $coupon->id], 'class' => 'coupon']) !!}

        @include('AdminLTE.coupon._form',['submitButtonText' => 'Сохранить купон'])
        {!! Form::close() !!}

    </div>

</div>
@endsection