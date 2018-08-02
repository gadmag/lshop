@extends('layouts.app')

@section('content')
@section('title', $catalog->name)
<nav aria-label="breadcrumb" role="navigation">
    <br>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$catalog->name}}</li>
    </ol>
</nav>

    <h1 class="title text-center">{{$catalog->name}}</h1>
    <div class="body">
        {!! $catalog->description !!}
    </div>
    {{--@if($article->type == 'news')--}}
        {{--<div class="article-pub"><span><i class="fa fa-calendar"></i> <i>{{$catalog->created_at}}</i></span></div>--}}
    {{--@endif--}}
<div class="row">
    @foreach ($catalog->products->chunk(4) as $productChunk)
        <div class="row">
            @foreach($productChunk as $product)
                <div class="col-sm-6 col-md-3">
                    <product-list :product="{{$product}}"
                                  @if($product->productSpecial()->exists())
                                  pricespecial = "@current_convert($product->productSpecial->price)"
                                  persentprice = "{{intval((($product->price - $product->productSpecial->price)/$product->price)*100)}}"
                                  @endif
                                  price="@current_convert($product->price)"
                                  productlink="{{$product->alias? "/products/$product->url_alias" : "products/$product->id"}}"
                                  @if($product->files()->first())
                                  imagepath="{{asset('storage/files/250x250/'.$product->files()->first()->filename)}}"
                            @endif

                    ></product-list>

                </div>
            @endforeach
        </div>
    @endforeach
</div>

@endsection