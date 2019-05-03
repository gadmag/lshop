@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home"></i> <a href="/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Каталог товаров</li>
            </ol>
        </nav>
    </div>
    <div class="panel-body">
        @if(Session::has('success'))
            <div class="row">
                <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
                    <div id="charge-message" class="alert alert-success">{{Session::get('success')}}</div>
                </div>
            </div>
        @endif
        <product-index :filters="{{$filters}}"></product-index>
    </div>
@endsection