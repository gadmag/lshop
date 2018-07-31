@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <a href="{{route('users.create')}}" class="btn btn-primary">
        <i class="fa fa-plus"></i>
        Добавить пользователя
    </a>
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
                <td class="table-text">{{$user->block? "Отключено" : "Включено"}}</td>
                <td class="table-text"> @if($user->roles()->first()) {{$user->roles()->first()->name}} @else
                        нет @endif</td>
                <td class="text-right">

                    <a style="display: inline-block" href="{{action('Admin\UserController@edit',[$user->id])}}" class="btn btn-info" title="Редактировать"
                       data-toggle="tooltip">
                        <i class="fa fa-edit"></i>
                    </a>


                    <!-- Delete Button -->

                    <form style="display: inline-block" action="{{ url('admin/user/'.$user->id) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <button style="display: inline-block" type="submit" class="btn btn-danger" data-toggle="tooltip" title="Удалить">
                            <i class="fa fa-trash"></i> Удалить
                        </button>
                    </form>


                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
@endsection