<div class="row">
    <div class="col-md-8 page-default">
        <div class="form-group">
            {!! Form::label('title', 'Название шрифта:') !!}
            {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('code', 'Код:') !!}
            {!! Form::text('code', old('code'), ['class' => 'form-control']) !!}
        </div>
    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
