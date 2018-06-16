
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
        <br>

        <div class="form-group">
            {!! Form::label('body', 'Содержимое:') !!}
            {!! Form::textarea('body', null, ['class' => 'ckeditor form-control']) !!}
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
                        {!! Form::label('pageSeo[meta_title]', 'Title:') !!}
                        {!! Form::text( 'pageSeo[meta_title]', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('pageSeo[meta_keywords]', 'Keywords:') !!}
                        {!! Form::text('pageSeo[meta_keywords]',  null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('pageSeo[meta_description]', 'Description:') !!}
                        {!! Form::textarea('pageSeo[meta_description]', null, ['class' => 'form-control']) !!}
                    </div>
                </fieldset>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <div class="box box-success collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Добавить пункт меню</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></a>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <fieldset>
                    <legend>Меню</legend>
                    <div style="">
                        <div class="form-group">
                            {!! Form::label('pageMenu[link_title]', 'Название ссылки:') !!}
                            {!! Form::text( 'pageMenu[link_title]', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('pageMenu[menu_type]', 'Меню') !!}
                            {!! Form::select('pageMenu[menu_type]',[
                            'main_menu' => 'Главное меню',
                            'second_menu' => 'Второстепенное меню',

                            ],null, ['class' => 'form-control', 'placeholder' => "-Выберите меню-"]) !!}
                        </div>
                        {{--<div class="form-group">--}}
                            {{--{{ Form::hidden('menuLink[menu_type]', 'mainmenu', array('id' => 'invisible_id')) }}--}}
                        {{--</div>--}}
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
