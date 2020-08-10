
<div class="row">
    <div class="col-md-8 page-default">
        <div class="form-group">
            {!! Form::label('title', 'Заголовок:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('css_class', 'Добавить класс:') !!}
            {!! Form::text('css_class', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('region', 'Регион') !!}
            {!! Form::select('region',$regions, null, ['class' => 'form-control', 'placeholder' => 'Выбрать регион']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('weight', 'Вес:') !!}
            {!! Form::number('weight', null, ['class' => 'form-control', 'style' => 'max-width: 80px']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
            {{Form::hidden('status',0)}}
            {!! Form::checkbox('status') !!}
        </div>


        <div class="form-group">
            {!! Form::label('body', 'Содержимое:') !!}
            {!! Form::textarea('body',  $block->description, null, ['class' => 'ckeditor  form-control']) !!}
        </div>

    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
