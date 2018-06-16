<div class="block block-forms">
    <div class="container">
    <div class="head-button">
        <a  id="btn-order"  class="btn active btn-default" href="#order"> Заказать</a>&nbsp;&nbsp;
        <a id="btn-backcall"  class="btn btn-default" href="#backcall"><i class="fa fa-mobile"></i> Обратный звонок</a>
    </div>
    <div id="order" class="form-content form-order col-md-8 col-md-offset-2">
        <form action="{{url('sendorder')}}" method="get">
            <div class="form-group">
                <div class="col-md-5 "> {!! Form::label('name', 'Как вас зовут?') !!}</div>
                <div class="col-md-7">{!! Form::input('text', 'name', null,  ['class' => 'form-control']) !!}</div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <div class="col-md-5"> {!! Form::label('email', 'Ваш адрес почты?') !!}</div>
                <div class="col-md-7">{!! Form::input('email', 'email',null,  ['class' => 'form-control']) !!}</div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <div class="col-md-5">{!! Form::label('telephone', 'Ваш номер телефона?') !!}</div>
                <div class="col-md-7">{!! Form::input('text', 'telephone', null, ['class' => 'form-control']) !!}</div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">

                <div class="col-md-10 col-md-offset-1">{!! Form::textarea('description', null,  ['class' => 'form-control']) !!}</div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group" style="text-align: center">
                <button class="btn btn-box-tool" data-widget="collapse">Отправить</button>
            </div>
        </form>
    </div>
    <div id="backcall" class="form-content form-backcall col-md-8 col-md-offset-2">
    <form action="{{url('sendcall')}}" method="get">
        <div class="form-group">
            <div style="text-align: center" class="col-md-5 "> {!! Form::label('name', 'Имя') !!}</div>
            <div class="col-md-7">{!! Form::input('text', 'name', null,  ['class' => 'form-control']) !!}</div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
            <div style="text-align: center" class="col-md-5">{!! Form::label('telephone', 'Телефон') !!}</div>
            <div class="col-md-7">{!! Form::input('text', 'telephone', null, ['class' => 'form-control']) !!}</div>
        </div>

        <div class="clearfix"></div>
        <div class="form-group" style="text-align: center">
            <button class="btn btn-box-tool" data-widget="collapse">Отправить</button>
        </div>
    </form>

    </div>
    </div>
</div><!-- block block-forms -->

