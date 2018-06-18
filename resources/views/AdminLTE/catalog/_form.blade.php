
<div class="row">

<div class="col-md-8 page-default">

<div class="form-group">
    {!! Form::label('name', 'Название:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
    <div class="form-group">
        {!! Form::label('alias[alias_url]', 'Адрес:') !!}
        {!! Form::text('alias[alias_url]', null, ['class'=>'form-control']) !!}
    </div>
<div class="form-group">
    {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
    {{Form::hidden('status',0)}}
    {!! Form::checkbox('status') !!}
</div>
    <div  class="input-group date dateru" >
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        {!! Form::input('text', 'published_at', $catalog->published_at, ['class' => 'form-control']) !!}

    </div>
<br>


    <div class="form-group">
    {!! Form::label('description', 'Содержимое:') !!}
    {!! Form::textarea('description', null, ['class' => 'ckeditor form-control']) !!}
        <script>
            var my_editor = 'description';
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
        @foreach($catalog->files as $file)
        <li id="file-item-{{$file->id}}" class="remove-file" data-id="{{$file->id}}"><span href="#" ><i class="fa fa-remove fa-lg"></i></span><img src="{{asset('storage/files/thumbnail/'.$file->filename)}}" alt="Картинка"></li>
        @endforeach
        </ul>
    </div>
    <div class="form-group">
        {!! Form::label('images', 'Фото категории') !!}
        {!! Form::file('images[]', array('multiple'=>true), ['class' => 'form-control' ]) !!}
        <p class="help-block">Выберите файл для добавления</p>
    </div>
</div>

<div class="col-md-3 pull-right seo-attr">
    <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Добавить сео аттрибуты</h3>
            <div class="box-tools pull-right">
                <a class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></a>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <fieldset>
                <legend>Сео аттрибуты</legend>
                <div class="form-group">
                    {!! Form::label('productSeo[meta_title]', 'Title:') !!}
                    {!! Form::text( 'productSeo[meta_title]', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('productSeo[meta_keywords]', 'Keywords:') !!}
                    {!! Form::text('productSeo[meta_keywords]',  null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('productSeo[meta_description]', 'Description:') !!}
                    {!! Form::textarea('productSeo[meta_description]', null, ['class' => 'form-control']) !!}
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
