<div class="row">
    <div class="col-md-8 page-default">
        <div class="form-group">
            {!! Form::label('name', 'Значение:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('order', 'Сортировать:') !!}
            {!! Form::text('order', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('type', $type, ['class' => 'form-control']) !!}
        </div>

    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
