<div class="row">
    {{--    {!! dd($article->alias) !!}--}}
    <div class="col-md-8 page-default">
        {{--        {!! dd($article->files) !!}--}}
        <div class="form-group required">
            {!! Form::label('name', 'Название:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group required">
            {!! Form::label('code', 'Код:') !!}
            {!! Form::text('code', null, ['class' => 'form-control']) !!}
        </div>

        {!! Form::label('discount', 'Скидка:') !!}
        <div class="form-inline">
            <div class="form-group required">
                {!! Form::number('discount', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::select('type', ['-' => '-', '%' => '%'], old('type'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('date_start', 'Дата начала:') !!}
                    <div class="input-group date" id="reservationdate_start"
                         data-target-input="nearest">
                        <div class="input-group-append" data-target="#reservationdate_start"
                             data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        {!! Form::input('text', 'date_start', old('date_start'), ['class' => 'form-control datetimepicker-input']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('date_end', 'Дата начала:') !!}
                    <div class="input-group date" id="reservationdate_end"
                         data-target-input="nearest">
                        <div class="input-group-append" data-target="#reservationdate_end"
                             data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                        {!! Form::input('text', 'date_end', old('date_end'), ['class' => 'form-control datetimepicker-input']) !!}
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="form-group required">
            {!! Form::label('uses_total', 'Количество применений купона:') !!}
            {!! Form::number('uses_total', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('status', 'Опубликовать:') !!}&nbsp;&nbsp;
            {{Form::hidden('status',0)}}
            {!! Form::checkbox('status') !!}
        </div>


    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
