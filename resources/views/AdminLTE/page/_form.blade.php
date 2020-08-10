
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
        </div>
        <div class="form-group">
            {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}
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
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<div class="clearfix"></div>

