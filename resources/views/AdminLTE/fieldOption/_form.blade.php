
<div class="row">
    {{--    {!! dd($article->alias) !!}--}}
    <div class="col-md-8 page-default">
        {{--        {!! dd($article->files) !!}--}}
        <div class="form-group">
            {!! Form::label('name', 'Значение:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('type', 'Поле') !!}
            {!! Form::select('type[]',[
            'material' => 'Материал',
            'coating' => 'Цвет покрытия',
            'stone' => 'Цвет камня'
            ], null, ['class' => 'form-control', 'placeholder' => 'Выбрать тип']) !!}
        </div>

    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
