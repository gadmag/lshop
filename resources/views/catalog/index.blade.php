
@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Каталог</li>
        </ol>
    </nav>
<h2>Наша продукция</h2>
<div class="our-products">
     <div class="block-content-middle row">
        @foreach ($catalogs as $catalog)

                <div class="col-sm-4 item-rows">
                    <div class="img-product">
                        <a href="/{{empty($catalog->alias->alias_url)? "product/$catalog->id" : $catalog->alias->alias_url}}">

                            @foreach($catalog->files as $file)
                                <img class="img-responsive" src="{{asset('storage/files/1250x700/'.$file->filename)}}" alt="{{$catalog->name}}">
                            @endforeach
                        </a>
                        <div class="out-product-item-wrapper">
                            <div class="title-product"><a href="/{{empty($catalog->alias->alias_url)? "catalog/$catalog->id" : $catalog->alias->alias_url}}">{{$catalog->name}}</a></div>

                        </div>
                    </div>

                </div>
        @endforeach
                </div>

        <div class="clearfix"></div>
</div>
@endsection