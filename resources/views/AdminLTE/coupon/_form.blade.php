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


        <div class="form-group required">
            {!! Form::label('discount', 'Скидка:') !!}
            {!! Form::number('discount', null, ['class' => 'form-control']) !!}
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('date_start', 'Дата начала:') !!}
                <div class="input-group date dateru">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    {!! Form::input('text', 'date_start', $coupon->date_start, ['class' => 'form-control']) !!}

                </div>
            </div>
            <div class="col-md-6">
                {!! Form::label('date_end', 'Дата оканчания:') !!}
                <div class="input-group date dateru">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    {!! Form::input('text', 'date_end', $coupon->date_end, ['class' => 'form-control']) !!}

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
