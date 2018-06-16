
@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$formTitle}}</li>
        </ol>
    </nav>
    <h2>{{$formTitle}}</h2>
    <p>Ваша заявка принята!</p>
@endsection