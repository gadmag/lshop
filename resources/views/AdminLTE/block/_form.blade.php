
<div class="row">
    {{--    {!! dd($article->alias) !!}--}}
    <div class="col-md-8 page-default">
        {{--        {!! dd($article->files) !!}--}}
        <div class="form-group">
            {!! Form::label('title', 'Заголовок:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('region', 'Регион') !!}
            {!! Form::select('region',[
            'right_top' => 'Правый верхний блок',
            'right_bottom' => 'Правый нижний блок'
            ], null, ['class' => 'form-control', 'placeholder' => 'Выбрать регион']) !!}
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



            {{--<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>--}}
            <script>
                var my_editor = 'body';
                var options = {
                    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
                };
            </script>
        </div>

    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
