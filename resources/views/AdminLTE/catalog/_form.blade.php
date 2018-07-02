<div class="row">

    <div class="col-md-8 page-default">

        <div class="form-group">
            {!! Form::label('name', 'Название:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('alias', 'Адрес:') !!}
            {!! Form::text('alias', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('order', 'Порядок сортировки') !!}
            {!! Form::text('order', null, ['class'=>'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
            {{Form::hidden('status',0)}}
            {!! Form::checkbox('status') !!}
        </div>

        <div class="form-group">
            {{--{{dd($catalog->parent_id)}}--}}
            {{--{!! Form::label('parent_list', 'Родительская категория') !!}--}}
            {{--{!! Form::select('parent_list[]',  ['null' => 'Выбрать'] + $catalogs ,$catalog? $catalog->parent_id : null , ['id'=> 'parent_list', 'class' => 'form-control']) !!}--}}

        </div>

        <div class="form-group">
            {!! Form::label('parent_list', 'Родительская категория') !!}
            <select class="form-control" name="parent_list" id="parent_list">
                <option value="0">Выбрать</option>
                @if($tree)
                @foreach($tree as $catItem)
                    @include('AdminLTE.form.select_catalog',  ['$catItem' => $catItem, 'catalog' => $catalog])
                @endforeach
                @endif
                {{--@each('AdminLTE.form.select', $tree, 'catItem')--}}

            </select>
        </div>
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
                    <li id="file-item-{{$file->id}}" class="remove-file" data-id="{{$file->id}}"><span href="#"><i
                                    class="fa fa-remove fa-lg"></i></span><img
                                src="{{asset('storage/files/thumbnail/'.$file->filename)}}" alt="Картинка"></li>
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
                        {!! Form::label('catalogSeo[meta_title]', 'Title:') !!}
                        {!! Form::text( 'catalogSeo[meta_title]', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('catalogSeo[meta_keywords]', 'Keywords:') !!}
                        {!! Form::text('catalogSeo[meta_keywords]',  null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('catalogSeo[meta_description]', 'Description:') !!}
                        {!! Form::textarea('catalogSeo[meta_description]', null, ['class' => 'form-control']) !!}
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
