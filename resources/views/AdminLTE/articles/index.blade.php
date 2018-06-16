@extends('AdminLTE.admin')

@section('AdminLTE.content')

@if($articleType->name == 'photo')
    @include('AdminLTE.articles._listPhoto')
@else
    @include('AdminLTE.articles._listArticle')
@endif

@endsection