@extends('layouts.app')

@section('content')
@section('title', $product->title)
@push('style')
    <link href="{{elixir('css/lightslider.css')}}" rel="stylesheet">
    <link href="{{elixir('/css/colorbox.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{elixir('/js/jquery.colorbox.js')}}"></script>
    <script src="{{elixir('js/lightslider.js')}}"></script>
    <script>
        $(document).ready(function(){
            //Examples of how to assign the Colorbox event to elements
            $(".group2").colorbox({rel:'group1', maxWidth:'95%', maxHeight:'95%'});
        });
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
                  @if($options) :options="{{$options}}" @endif
                  @if($discount)  :discount="{{$discount}}" @endif
                  @if($special) :special="{{$special}}" @endif
                  {{--action="{{route('product.addToCart')}}"--}}
                  @if($product->files()->exists()):images="{{$product->files}}" @endif
                  {{--@if($options->files()->exists()):images_option="{{$options->files}}" @endif--}}

    ></product-page>
</div>
@if(count($products) > 0)
    <div class="block bottom-page">
        <h2 class="title text-center">Похожие товары</h2>
        <div class="row">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-3">
                    <product-list :product="{{$product}}"
                                  @if($product->productSpecial()->betweenDate()->exists())
                                  pricespecial="{{$product->productSpecial->price}}"
                                  persentprice="{{intval((($product->price - $product->productSpecial->price)/$product->price)*100)}}"
                                  @endif
                                  price="{{$product->price}}"
                                  productlink="{{$product->alias? "/products/$product->url_alias" : "products/$product->id"}}"
                                  @if($product->files()->first())
                                  imagepath="{{asset('storage/files/250x250/'.$product->files()->first()->filename)}}"
                            @endif

                    ></product-list>

                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection