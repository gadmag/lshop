
<div class="row">
{{--    {!! dd($article->alias) !!}--}}
    <div class="col-md-8 page-default">
{{--        {!! dd($article->files) !!}--}}
        <div class="form-group">
            {!! Form::label('title', 'Заголовок:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('alias', 'Адрес:') !!}
            {!! Form::text('alias', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('catalog_list', 'Категория новости') !!}

            {!! Form::select('catalog_list[]', $catalogs,  null, ['id'=> 'catalog_lists', 'class' => 'form-control', 'multiple'=>'multiple']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
            {{Form::hidden('status',0)}}
            {!! Form::checkbox('status') !!}
        </div>
        <div class="form-group">
            {{$article->language}}
            {!! Form::label('lang', 'Ногайский язык:') !!}&nbsp;&nbsp;
            {{Form::hidden('lang',0)}}
            {!! Form::checkbox('lang') !!}
        </div>
        <div  class="input-group date dateru" >

            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            {!! Form::input('text', 'published_at', $article->published_at, ['class' => 'form-control']) !!}

        </div>
        <br>
        {{--<div class="form-group">--}}
            {{--{!! Form::label('tag_list', 'Теги:') !!}--}}

            {{--{!! Form::select('tag_list[]', $tags,  null, ['id'=> 'tag_lists', 'class' => 'form-control', 'multiple'=>'multiple']) !!}--}}

        {{--</div>--}}

        <div class="form-group">
            {!! Form::label('body', 'Содержимое:') !!}
            {!! Form::textarea('body',  $article->description? $article->description.'<hr>'.$article->body: null, ['class' => 'ckeditor  form-control']) !!}



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

        <div class="form-group">
            <ul class="list-inline">
                @foreach($article->files as $file)
                    <li id="file-item-{{$file->id}}" class="remove-file" data-id="{{$file->id}}"><span href="#" ><i class="fa fa-remove fa-lg"></i></span><img src="{{asset('storage/files/thumbnail/'.$file->filename)}}" alt="Картинка"></li>
                @endforeach
            </ul>
        </div>
        <div class="form-group">
            {!! Form::label('images', 'Картинки') !!}
            {!! Form::file('images[]', array('multiple'=>true), ['class' => 'form-control' ]) !!}
            <p class="help-block">Выберите файл для добавления</p>
        </div>
    </div>

    <div class="col-md-3 pull-right seo-attr">
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Сео аттрибуты</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <fieldset>
                    <legend>Сео аттрибуты</legend>
                    <div class="form-group">

                        {!! Form::label('seoAttr[title_seo]', 'Title:') !!}
                        {!! Form::text( 'seoAttr[title_seo]', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('seoAttr[keywords]', 'Keywords:') !!}
                        {!! Form::text('seoAttr[keywords]',  null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('seoAttr[description]', 'Description:') !!}
                        {!! Form::textarea('seoAttr[description]', null, ['class' => 'form-control']) !!}
                    </div>
                </fieldset>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div>
</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
