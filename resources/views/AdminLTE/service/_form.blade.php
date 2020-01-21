<div class="row">
    <div class="col-md-8 page-default">
        <div class="form-group">
            {!! Form::label('title', 'Название услуги:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
            {{Form::hidden('status',0)}}
            {!! Form::checkbox('status') !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('type', $type, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('price', 'Цена:') !!}
            {!! Form::text('price', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('order', 'Сортировать:') !!}
            {!! Form::text('order', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Описание:') !!}
            {!! Form::textarea('description', old('description'), ['class' => 'ckeditor form-control']) !!}
        </div>
    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
