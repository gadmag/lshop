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
        <product-index :filters="{{$filters}}"></product-index>
    </div>
@endsection