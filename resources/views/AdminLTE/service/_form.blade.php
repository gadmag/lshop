<div class="row">
    <div class="col-md-8 page-default">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Общие</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab">Данные</a></li>
                <li class=""><a href="#tab_4" data-toggle="tab">Скидки</a></li>
                <li class=""><a href="#tab_5" data-toggle="tab">Акция</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
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
                    <div class="form-group">

                        {!! Form::label('catalog_list', 'Родительская категория') !!}
                        <select class="form-control" name="catalog_list[]" id="catalog_list" multiple="multiple">
                            <option value="0">Выбрать</option>
                            @if($catalogs)
                                @foreach($catalogs as $catItem)
                                    @include('AdminLTE.form.select_product',  ['$catItem' => $catItem])
                                @endforeach
                            @endif

                        </select>
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
                                            href="#"><i class="fa fa-remove fa-lg"></i></span><img class="thumbnail"
                                                                                                   src="{{asset('storage/files/thumbnail/'.$file->filename)}}"
                                                                                                   alt="Картинка">
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
                <div id="tab_2" class="tab-pane">
                    <div class="form-group">
                        {!! Form::label('sku', 'Артикл:') !!}
                        {!! Form::text('sku', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('model', 'Модель:') !!}
                        {!! Form::text('model', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('price', 'Цена:') !!}
                        {!! Form::text('price', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('material', 'Материал:') !!}
                        {!! Form::select('material', $product->getFieldOptions('material'), null, ['class' => 'form-control', 'placeholder' => 'Выбрать материал']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('size', 'Размер:') !!}
                        {!! Form::text('size',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('sort_order', 'Порядок сортировки:') !!}
                        {!! Form::text('sort_order',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('quantity', 'Кол-во:') !!}
                        {!! Form::text('quantity',1, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div id="tab_4" class="tab-pane">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::hidden('productDiscount[id]', null) !!}
                                {!! Form::label('productDiscount[quantity]', 'Количество:') !!}
                                {!! Form::text('productDiscount[quantity]', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('productDiscount[price]', 'Цена:') !!}
                            <div class="form-inline">
                                <div class="form-group">
                                    {!! Form::text('productDiscount[price]', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::select('productDiscount[price_prefix]', ['-' => '-', '%' => '%'], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab_5" class="tab-pane">
                    <div class="row">
                        <div class="col-md-4">
                            {!! Form::label('productSpecial[price]', 'Цена:') !!}
                            <div class="form-inline">
                                <div class="form-group">
                                    {!! Form::hidden('productSpecial[id]', null) !!}

                                    {!! Form::text('productSpecial[price]', null, ['class' => 'form-control']) !!}

                                </div>
                                <div class="form-group">
                                    {!! Form::select('productSpecial[price_prefix]', ['-' => '-', '%' => '%'], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('productSpecial[date_start]', 'Дата начала:') !!}
                            <div class="input-group date dateru">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                {!! Form::input('text', 'productSpecial[date_start]', null, ['class' => 'form-control']) !!}

                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('productSpecial[date_end]', 'Дата оканчания:') !!}
                            <div class="input-group date dateru">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                {!! Form::input('text', 'productSpecial[date_end]', null, ['class' => 'form-control']) !!}

                            </div>
                        </div>
                    </div>
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
