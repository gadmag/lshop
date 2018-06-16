<div class="row">
    {{--{!! dd($article->seo_ele) !!}--}}
    <div class="col-md-5 page-default">

        <div class="form-group">
            {!! Form::label('link_title', 'Название ссылки') !!}
            {!! Form::text('link_title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('link_path', 'Адрес:') !!}
            {!! Form::text('link_path', null, ['class'=>'form-control']) !!}
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
