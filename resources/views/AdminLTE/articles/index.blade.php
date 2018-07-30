@extends('AdminLTE.admin')

@section('AdminLTE.content')

    @if($articleType->name == 'photo')
        @include('AdminLTE.articles._listPhoto')
    @elseif($articleType->name == 'design')
        @include('AdminLTE.articles._list_design')
    @else
        @include('AdminLTE.articles._listArticle')
    @endif

@endsection