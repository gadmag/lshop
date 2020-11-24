<div class="row">
    <div class="col-md-5 page-default">
        <div class="form-group">
            {!! Form::label('title', 'Название ссылки') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('path', 'Адрес:') !!}
            {!! Form::text('path', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('class', 'Класс:') !!}
            {!! Form::text('class', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('visible', 'Показать:') !!}
            {!! Form::checkbox('visible', null, ['class'=>'form-control']) !!}
        </div>


        <br>

    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
