@extends('AdminLTE.admin')

@section('AdminLTE.content')

    {{--@include('AdminLTE.articles._listArticle')--}}
    @if($type == 'mainmenu')
        <h2>Главное меню</h2>
    @elseif($type == 'secondmenu')
        <h2>Меню каталога</h2>
    @endif

    @include('AdminLTE.menu._listMenu')


@endsection