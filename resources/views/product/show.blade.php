@extends('layouts.app')

@section('content')
@section('title', $product->title)
@push('style')
    <link href="{{elixir('css/lightslider.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{elixir('js/lightslider.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#light-slider').lightSlider({
                gallery: true,
                item: 1,
                vertical: true,
                verticalHeight: 300,
                vThumbWidth: 90,
                thumbItem: 4,
                thumbMargin: 4,
                slideMargin: 0
            });
        });
    </script>
    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
    <script src="//yastatic.net/share2/share.js"></script>
@endpush

<nav aria-label="breadcrumb" role="navigation">
    <br>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{url('products')}}">Продукты</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
    </ol>
</nav>

<div class="product-page">

    <product-page :product="{{$product}}"
                  @if($options) :options="{{$options}}"@endif
                  @if($discount)  :discount="{{$discount}}"@endif
                  @if($special) :special="{{$special}}"@endif
                    {{--action="{{route('product.addToCart')}}"--}}
                  @if($product->files()->exists())
                  :images="{{$product->files}}"
            @endif

    ></product-page>
</div>

@endsection