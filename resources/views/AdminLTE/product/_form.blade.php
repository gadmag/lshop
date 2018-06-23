<div class="row">

    {{--    {!! dd($product->seo_ele) !!}--}}
    <div class="col-md-8 page-default">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Данные</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab">Опции</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab">Tab 3</a></li>

            </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <div class="form-group">
                        {!! Form::label('title', 'Заголовок:') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
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
                    <div class="form-group">

                        {!! Form::label('catalog_list', 'Категория продукта') !!}

                        {!! Form::select('catalog_list[]', $catalogs,  null, ['id'=> 'catalog_lists', 'class' => 'form-control', 'multiple'=>'multiple']) !!}

                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Описание:') !!}
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
                            @foreach($product->files as $file)
                                <li id="file-item-{{$file->id}}" class="remove-file" data-id="{{$file->id}}"><span
                                            href="#"><i class="fa fa-remove fa-lg"></i></span><img
                                            src="{{asset('storage/files/thumbnail/'.$file->filename)}}" alt="Картинка">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group">
                        {!! Form::label('images', 'Фото продукта') !!}
                        {!! Form::file('images[]', array('multiple'=>true), ['class' => 'form-control' ]) !!}
                        <p class="help-block">Выберите файл для добавления</p>
                    </div>
                </div>
                <div id="tab_2" class="tab-pane active">
                    2Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, voluptatem!
                </div>
            </div>
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
