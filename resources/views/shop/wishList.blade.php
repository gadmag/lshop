@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Избранное</li>
        </ol>
    </nav>
    @if (Session::has('wishList'))
    <div class="row">
        <h1 class="title text-center">Избранное</h1>
            <div class="row">
                {{--{{dd($wishList)}}--}}
                @foreach ($wishList->chunk(4) as $wishListChunk)
                    <div class="row">
                        @foreach($wishListChunk as $product)
                            <div class="col-sm-6 col-md-3">
                                <wish-list :product="{{$product}}"
                                           price = "@current_convert($product->price)"
                                           productlink = "{{$product->alias? "products/$product->alias" : "products/$product->id"}}"
                                           @if($product->files()->first())
                                           imagepath = "{{asset('storage/files/250x250/'.$product->files()->first()->filename)}}"
                                        @endif
                                ></wish-list>


                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

    </div>
    @else
       <div class="row">
           <h1 class="title text-center"> Нет избранных товаров</h1>
       </div>
    @endif

@endsection