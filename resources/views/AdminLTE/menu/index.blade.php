@extends('AdminLTE.admin')

@section('AdminLTE.content')

    @push('style')
        <link href="{{asset('AdminLTE/css/jquery.nestable.css')}}" rel="stylesheet">
    @endpush
    @push('scripts')
        <script src="{{asset('AdminLTE/js/jquery.nestable.min.js')}}"></script>
    @endpush
    @if($type == 'mainmenu')
        <h2>Главное меню</h2>
    @elseif($type == 'secondmenu')
        <h2>Меню каталога</h2>
    @endif

    @include('AdminLTE.menu._listMenu')


@endsection