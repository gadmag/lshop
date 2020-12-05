<div class="row">

    <div class="col-md-8 page-default">
        <div class="card card-primary">
            <div class="card-header">{{$title}}</div>
            <div class="card-body">
{{--                {{dd($catalog->catalogSeo)}}--}}
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
                </div>


                <div class="form-group">
                    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3  seo-attr">
        <div class="card card-outline collapsed-card card-primary">
            <div class="card-header">
                <h3 class="card-title">Добавить сео аттрибуты</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
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
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-outline collapsed-card card-primary">
            <div class="card-header">
                <h3 class="card-title">Добавить пункт меню</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <fieldset>
                    <legend>Меню</legend>
                    <div style="">
                        <div class="form-group">
                            {!! Form::label('catalogMenu[title]', 'Название ссылки:') !!}
                            {!! Form::text( 'catalogMenu[title]', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('catalogMenu[menu_type]', 'Меню') !!}
                            {!! Form::select('catalogMenu[menu_type]',[
                            'main_menu' => 'Главное меню',
                            'second_menu' => 'Второстепенное меню',

                            ],null, ['class' => 'form-control', 'placeholder' => "-Выберите меню-"]) !!}
                        </div>
                    </div>
                </fieldset>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

