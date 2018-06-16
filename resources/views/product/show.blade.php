@extends('layouts.app')

@section('content')
@section('title', $product->title)
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{url('products')}}">Продукты</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
        </ol>
    </nav>
                    <h1 class="heading">{{$product->title}}</h1>
                    {{--@if($product->type == 'news')--}}
                        {{--<div class="article-pub"><span><i class="fa fa-calendar"></i> <i>{{$article->published_at}}</i></span></div>--}}
                        {{--@endif--}}
                    <div class="article-body">
                        {{--@foreach($product->files as $file)--}}

                            <img style="float: left; padding-right: 10px" class="img-responsive" src="{{asset('storage/files/400x300/'.$product->files()->first()->filename)}}" alt="Картинка">

                                              {{--@endforeach--}}
                        <article>
                            {!! $product->description !!}
                            <div class="clearfix"></div>
                            <div class="info-order text-right">
                                <button type="button" class="btn btn-green btn-lg" data-toggle="modal" data-target="#myModal">Заказать</button>
                            </div>
                            <footer>

                                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                                    <script src="//yastatic.net/share2/share.js"></script>
                                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,whatsapp"></div>

                            </footer>
                        </article>
                        @if(!$products->isEmpty())
                        <h3>Похожие продукты</h3>
                        <div class="row">
                        @foreach($products as $product)
                            <div class="product-item col-sm-4">
                                <div class="product-wrap">
                                    {{--        {!! $product !!}--}}
                                    @if($product->files)
                                        <img class="img-responsive" src="{{asset('storage/files/600x450/'.$product->files()->first()->filename)}}" alt="Картинка">
                                    @endif
                                    <div class="product-title"><a href="/{{empty($product->alias->alias_url)? "product/$product->id" : $product->alias->alias_url}}">{{$product->title}}</a></div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        @endif
                            {{--<ul class="list-inline">--}}
                                {{--<li>Tags:</li>--}}
                                {{--@foreach($article->tags as $tags)--}}
                                {{--<li><a href="{{action('TagsController@show',[$tags->name])}}">{{$tags->name}}</a></li>--}}
                                {{--@endforeach--}}
                            {{--</ul>--}}

                    </div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Оформить заказ</h4>
            </div>
            <div class="modal-body">
                <div id="order" class="form-content form-order">
                    <form action="{{url('sendorder')}}" method="get">
                        <div class="form-group">
                            {!! Form::input('text', 'name', null,  ['class' => 'form-control', 'placeholder' => 'Имя']) !!}
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            {!! Form::input('email', 'email',null,  ['class' => 'form-control','placeholder' => 'E-mail']) !!}
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            {!! Form::input('text', 'telephone', null, ['class' => 'form-control', 'placeholder' => 'Телефон']) !!}
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            {!! Form::textarea('description', null,  ['class' => 'form-control','placeholder' => 'Сообщение']) !!}
                        </div>
                        {!!  Form::input('title_product', 'telephone', $product->title, ['class' => 'hidden form-control']) !!}
                        <div class="clearfix"></div>
                        <div class="form-group" style="text-align: center">
                            <button class="btn btn-box-tool" data-widget="collapse">Отправить</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>
@endsection