
<div class="row">
    <div class="col-md-8 page-default">
        <div class="form-group">
            {!! Form::label('username', 'Username:') !!}
            {!! Form::text('username', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('name', 'Имя:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Почта:') !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', 'Пароль:') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('role_list', 'Категория новости') !!}

            {!! Form::select('role_list[]', $roles,  null, ['id'=> 'role_lists', 'class' => 'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('block', 'Блокировать:') !!}&nbsp;&nbsp;
            {{Form::hidden('block',0)}}
            {!! Form::checkbox('block') !!}
        </div>
        <br>


    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
