
<div class="row">
    {{--{!! dd($article->seo_ele) !!}--}}
    <div class="col-md-8 page-default">

        <div class="form-group">
            {!! Form::label('title', 'Заголовок:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
            {{Form::hidden('status',0)}}
            {!! Form::checkbox('status') !!}
        </div>
        <div class="col-md-6">
        <span><b>Дата начала:</b></span>
        <div  class="input-group date dateru" >
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            {!! Form::input('text', 'eventAttr[start_time]',null, ['class' => 'form-control']) !!}

        </div>
        </div>
        {{--<br><br>--}}
        <div class="col-md-6">
        <span><b>Дата окончания:</b></span>
            <div class="input-group date dateru">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                {!! Form::input('text', 'eventAttr[end_time]',null, ['class' => 'form-control']) !!}

            </div>
        </div>
        <div class="clearfix"></div>
        <br><br>
        <div class="form-group">
            {!! Form::label('tag_list', 'Теги:') !!}

            {!! Form::select('tag_list[]', $tags,  null, ['id'=> 'tag_lists', 'class' => 'form-control', 'multiple'=>'multiple']) !!}

        </div>

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

</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
