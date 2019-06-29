@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Главная</a></li>

            <li class="breadcrumb-item active" aria-current="page">Пользователи</li>
        </ol>
    </nav>
    <a href="{{route('users.create')}}" class="btn btn-primary">
        <i class="fa fa-plus"></i>
        Добавить пользователя
    </a>
    <br>
    <table class="table table-striped">
        <thead>
        <th>Имя</th>
        <th>Email</th>
        <th>Статус</th>
        <th>Роль</th>
        </thead>
        <tbody>
        @foreach($users as $user)

            <tr>

                <td class="table-text">{{$user->name}}</td>
                <td class="table-text">{{$user->email}}</td>
                <td class="table-text">{{$user->blocked? "Отключено" : "Включено"}}</td>
                <td class="table-text"> @if($user->roles()->first()) {{$user->roles()->first()->name}} @else
                        нет @endif</td>
                <td class="text-right">

                    <a style="display: inline-block" href="{{action('Admin\UserController@edit',[$user->id])}}" class="btn btn-info" title="Редактировать"
                       data-toggle="tooltip">
                        <i class="fa fa-edit"></i>
                    </a>


                    <!-- Delete Button -->

                    <form style="display: inline-block" action="{{ url('admin/users/'.$user->id) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <button onclick="return confirm('Вы хотите удалить пользователя?')" style="display: inline-block" type="submit" class="btn btn-danger" data-toggle="tooltip" title="Удалить">
                            <i class="fa fa-trash"></i> Удалить
                        </button>
                    </form>


                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
@endsection