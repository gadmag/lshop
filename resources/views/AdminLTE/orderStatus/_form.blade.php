<div class="row">
    <div class="col-md-8 page-default">
        <div class="form-group">
            {!! Form::label('name', 'Значение:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('css_class', 'Класс:') !!}
            {!! Form::text('css_class', null, ['class' => 'form-control']) !!}
        </div>
    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
