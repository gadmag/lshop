<div class="row">
    {{--{!! dd($article->seo_ele) !!}--}}
    <div class="col-md-8 page-default">
        <div class="form-group">
            {!! Form::label('title', 'Заголовок:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('name', 'Имя:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
            {{Form::hidden('status',0)}}
            {!! Form::checkbox('status') !!}
        </div>
        <div class="form-group">
            {!! Form::label('order', 'Порядок сортировки:') !!}
            {!! Form::text('order', null, ['class'=>'form-control']) !!}
        </div>
        <br>
        <div class="image-list">
            <ul class="list-inline">
                @if($shipment->files)
                    <li id="file-item-{{$shipment->files->id}}" class="remove-file" data-id="{{$shipment->files->id}}">
                        <span><i class="fa fa-remove fa-lg"></i></span>
                        <img class="thumbnail" src="{{asset('storage/files/thumbnail/'.$shipment->files->filename)}}"
                             alt="Картинка">
                    </li>
                @endif
            </ul>
        </div>
        <div class="form-group">
            {!! Form::label('images', 'Картинка ') !!}
            {!! Form::file('images[]',['multiple' => true],  ['class' => 'form-control' ]) !!}
            <p class="help-block">Выберите файл для добавления</p>
        </div>
        <br>
        <shipment-field :shipments="{{ ($shipment && $shipment->price_setting)? json_encode($shipment->price_setting):'[]'}}"></shipment-field>
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
