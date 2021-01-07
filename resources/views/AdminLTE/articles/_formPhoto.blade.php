
<div class="row">
    {{--{!! dd($article->seo_ele) !!}--}}
    <div class="col-md-8 page-default">

        <div class="form-group">
            {!! Form::label('title', 'Заголовок:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
            {{Form::hidden('status',0)}}
            {!! Form::checkbox('status') !!}
        </div>
        <div class="form-group">
            {!! Form::label('published_at', 'Дата публикации:') !!}
            <div class="input-group date" id="published_at"
                 data-target-input="nearest">
                <div class="input-group-append" data-target="#published_at"
                     data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                </div>
                {!! Form::input('text', 'published_at', old('published_at'), ['class' => 'form-control datetimepicker-input']) !!}

            </div>
        </div>
        <br>
        <div class="form-group">
            {!! Form::label('body', 'Содержимое:') !!}
            {!! Form::textarea('body', null, ['class' => 'ckeditor form-control']) !!}
        </div>
        <div class="form-group">
            <image-upload name="articleUpload" action="{{route('upload.files')}}"
                          :files="{{$article->files}}"></image-upload>
        </div>
    </div>

    <div class="col-md-3 pull-right seo-attr">
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
