@extends('layouts.app')

@section('content')
@section('title', $product->meta_title)
@section('keywords', $product->meta_keywords)
@section('description', $product->meta_description)
@section('og_tags')
    <meta property="og:title" content="{{$product->title}}"/>
    <meta property="og:description" content="{{words(strip_tags($product->description),40)}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:image" content="{{$product->frontImg()}}"/>
@endsection
@push('style')
    <link href="{{asset('/css/colorbox.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{asset('/js/jquery.colorbox.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".group2").colorbox({
                rel: 'group1',
                current: 'Фото {current} из {total}',
                maxWidth: '95%',
                maxHeight: '95%'
            });
        });

    </script>
    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
    <script src="//yastatic.net/share2/share.js"></script>
@endpush

<div class="container">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{url('products')}}">Каталог товаров</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{$product->title}}</span></li>
        </ol>
    </nav>
</div>
<div class="product-page">
    <div class="container">
        <product-page :fonts="{{$product->fonts()}}" :product="{{$product}}"></product-page>
    </div>

</div>
@if(count($products) > 0)
    <div class="block bottom-page mt-5">
        <h2 class="py-3 title text-center">Похожие товары</h2>
        <div class="container">
            <product-list :products="{{$products}}"></product-list>
        </div>
    </div>
@endif
@endsection