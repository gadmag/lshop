
<div class="row">
    {{--{!! dd($article->seo_ele) !!}--}}
<div class="col-md-8 page-default">

<div class="form-group">
    {!! Form::label('title', 'Заголовок:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>
    <div class="form-group">
        {!! Form::label('alias', 'Адрес:') !!}
        {!! Form::text('alias', null, ['class'=>'form-control']) !!}
    </div>
<div class="form-group">
    {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
    {{Form::hidden('status',0)}}
    {!! Form::checkbox('status') !!}
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
    {!! Form::textarea('body', null, ['class' => 'ckeditor form-control']) !!}
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
            <h3 class="box-title">Добавить сео аттрибуты</h3>
            <div class="box-tools pull-right">
                <a class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></a>
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
    <div class="box box-success collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Добавить пункт меню</h3>
            <div class="box-tools pull-right">

                {{--{{Form::hidden('hasMenu',0)}}--}}
                {{--{!! Form::checkbox('hasMenu', null, ['class' => 'collapse'])!!}--}}
                <input name="hasMenu" value="0" type="hidden">
                <input data-widget="collapse" @if ($article->menuLink){{'checked'}}@endif value="1" name="hasMenu" type="checkbox">
                <a class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
{{--                    {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;--}}

                </a>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <fieldset>
                <legend>Меню</legend>
                <div style="">
                <div class="form-group">
                    {!! Form::label('menuLink[link_title]', 'Название ссылки:') !!}
                    {!! Form::text( 'menuLink[link_title]', null, ['class' => 'form-control']) !!}
                </div>
                {{--<div class="form-group">--}}
                    {{--{!! Form::label('menuLink[link_path]', 'Адрес ссылки:') !!}--}}
                    {{--{!! Form::text('menuLink[link_path]',  null, ['class' => 'form-control']) !!}--}}
                {{--</div>--}}
                <div class="form-group">
                    {{ Form::hidden('menuLink[menu_type]', 'mainmenu', array('id' => 'invisible_id')) }}
                </div>
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
