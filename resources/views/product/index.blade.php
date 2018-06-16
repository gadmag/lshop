@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Все продукты</li>
        </ol>
    </nav>

    <h1>Все продукты</h1>
    <div class="panel-body">
        @if(Session::has('success'))
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="charge-message" class="alert alert-success">{{Session::get('success')}}</div>
            </div>
        </div>
        @endif
        <div class="row">
            @foreach ($products->chunk(3) as $productChunk)
                @foreach($productChunk as $product)
                    <div class="col-sm-6 col-md-4">
                        <product :product="{{$product}}"
                                 addtocart = "{{route('product.addToCart', ['id' => $product->id])}}"
                                 productlink = "{{empty($product->alias->alias_url)? "product/$product->id" : $product->alias->alias_url}}"
                                 @if($product->files()->first())
                                 imagepath = "{{asset('storage/files/600x450/'.$product->files()->first()->filename)}}"
                                 @endif

                          ></product>

                    </div>
                @endforeach

            @endforeach
        </div>
    </div>
    {{$products->links()}}

@endsection