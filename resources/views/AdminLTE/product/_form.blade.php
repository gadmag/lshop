<div class="row">
    <div class="col-lg-12 col-xl-10 page-default">

        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="pill" role="tab"
                                            aria-controls="custom-tabs-three-home" aria-selected="true">Общие</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="pill" role="tab"
                                            aria-controls="custom-tabs-three-home" aria-selected="true">Данные</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="pill" role="tab"
                                            aria-controls="custom-tabs-three-home" aria-selected="true">Опции</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="pill" role="tab"
                                            aria-controls="custom-tabs-three-home" aria-selected="true">Акция</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_5" data-toggle="pill" role="tab"
                                            aria-controls="custom-tabs-three-home" aria-selected="true">Услуги</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div id="tab_1" class="tab-pane fade show active">
                        <div class="form-group">
                            {!! Form::label('title', 'Заголовок:') !!}
                            {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('alias', 'Адрес:') !!}
                            {!! Form::text('alias', old('alias'), ['class'=>'form-control']) !!}
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
                            {!! Form::textarea('description', old('description'), ['class' => 'editor form-control']) !!}

                        </div>

                        <div class="form-group">
                            <image-upload name="productUpload" action="{{route('upload.files')}}"
                                           :files="{{$product->files}}"></image-upload>
                        </div>
                    </div>
                    <div id="tab_2" class="tab-pane fade">
                        <div class="form-group">
                            {!! Form::label('model', 'Модель:') !!}
                            {!! Form::text('model', old('model'), ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('material', 'Материал:') !!}
                            {!! Form::select('material', $product->getFieldOptions('material'), null, ['class' => 'form-control', 'placeholder' => 'Выбрать материал']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('size', 'Размер:') !!}
                            {!! Form::text('size', old('size'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('sort_order', 'Порядок сортировки:') !!}
                            {!! Form::text('sort_order',old('sort_order'), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div id="tab_3" class="tab-option-coating fade tab-options tab-pane">

                        <option-item
                                :options="{{$product->productOptions()->with('files','discount')->get()}}"
                                :old_options="{{json_encode(old('productOptions')?:[])}}"
                                :colors="{{collect($product->getFieldOptions('coating'))}}"
                                :colors_stone="{{collect($product->getFieldOptions('stone'))}}"
                                action="{{route('upload.files')}}">

                        </option-item>
                    </div>
                    <div id="tab_4" class="fade tab-pane">
                        <div class="row">
                            <div class="col-md-4">
                                {!! Form::label('productSpecial[price]', 'Цена:') !!}
                                <div class="form-inline">
                                    <div class="form-group">
                                        {!! Form::hidden('productSpecial[id]', null) !!}

                                        {!! Form::text('productSpecial[price]', old('productSpecial[price]'), ['class' => 'form-control']) !!}

                                    </div>
                                    <div class="form-group">
                                        {!! Form::select('productSpecial[price_prefix]', ['-' => '-', '%' => '%'], old('productSpecial[price_prefix]'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('productSpecial[date_start]', 'Дата начала:') !!}
                                    <div class="input-group date" id="reservationdate_start"
                                         data-target-input="nearest">
                                        <div class="input-group-append" data-target="#reservationdate_start"
                                             data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                        </div>
                                        {!! Form::input('text', 'productSpecial[date_start]', old('productSpecial[date_start]'), ['class' => 'form-control datetimepicker-input']) !!}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('productSpecial[date_end]', 'Дата оканчания:') !!}
                                    <div class="input-group date" id="reservationdate_end" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#reservationdate_end" data-toggle="datetimepicker">
                                            <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::input('text', 'productSpecial[date_end]', old('productSpecial[date_end]'), ['class' => 'form-control']) !!}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab_5" class="fade tab-pane">
                        <div class="form-group">
                            {!! Form::label('service_list', 'Гравировка') !!}
                            <select class="form-control" name="service_list[]" id="service_list" multiple="multiple">

                                @if($services)
                                    @foreach($services as $service)
                                        <option @if($product->services) {{in_array($service->id, $product->services->pluck('id')->toArray())? 'selected' : ''}} @endif value="{{$service->id}}">{{$service->title}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
            <div class="px-4 form-group">
                {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}
            </div>
        </div>

    </div>

    <div class="col-xl-2 pull-right seo-attr">
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
                        {!! Form::label('productSeo[meta_title]', 'Title:') !!}
                        {!! Form::text( 'productSeo[meta_title]', old('productSeo[meta_title]'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('productSeo[meta_keywords]', 'Keywords:') !!}
                        {!! Form::text('productSeo[meta_keywords]',  old('productSeo[meta_keywords]'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('productSeo[meta_description]', 'Description:') !!}
                        {!! Form::textarea('productSeo[meta_description]', old('productSeo[meta_description]'), ['class' => 'form-control']) !!}
                    </div>
                </fieldset>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<div class="clearfix"></div>

