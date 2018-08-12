@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Поиск</li>
        </ol>
    </nav>

    <h1 class="title text-center">Поиск</h1>

    <div class="panel-body">
        @if(Session::has('success'))
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                    <div id="charge-message" class="alert alert-success">{{Session::get('success')}}</div>
                </div>
            </div>
        @endif
        @if(count($products) > 0)
        <div class="row">
            @foreach ($products->chunk(4) as $productChunk)
                <div class="row">
                    @foreach($productChunk as $product)
                        <div class="col-sm-6 col-md-3">
                            <product-list :product="{{$product}}"
                                     @if($product->productSpecial()->betweenDate()->exists())
                                            pricespecial = "{{$product->productSpecial->price}}"
                                            persentprice = "{{intval((($product->price - $product->productSpecial->price)/$product->price)*100)}}"
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
            @endforeach
        </div>
            @else
            <div class="row">
                <p>Нет товаров, соответствующих критериям поиска.</p>
            </div>
        @endif
    </div>
    {{$products->links()}}

@endsection