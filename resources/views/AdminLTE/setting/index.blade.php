@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title', 'Параметры сайта')
<div class="col-md-9">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                @foreach(config('settings') as $section => $fields)
                    <li class="nav-item">
                        <a class="nav-link {{$loop->first?'active':''}}" id="custom-tabs-{{$section}}-tab"
                           data-toggle="pill" href="#custom-tabs-{{$section}}" role="tab"
                           aria-controls="custom-tabs-three-home"
                           aria-selected="{{$loop->first?'true':'false'}}">{{$fields['title']}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('settings.store') }}" class="form-horizontal" role="form">
                {!! csrf_field() !!}
            <div class="tab-content" id="custom-tabs-three-tabContent">
                @if(count(config('settings', [])) )
                        @foreach(config('settings') as $section => $fields)
                            <div class="tab-pane fade {{$loop->first? 'show active':''}}" id="custom-tabs-{{$section}}"
                                 role="tabpanel" aria-labelledby="custom-tabs-{{$section}}-tab">
                                <p class="text-muted">{{ $fields['desc'] }}</p>
                                @foreach($fields['fields'] as $field)
                                    @includeIf('AdminLTE.setting.fields.' . $field['type'] )
                                @endforeach
                            </div>
                        @endforeach
                        <div class="row m-b-md">
                            <div class="col-md-12">
                                <button class="btn-primary btn">Сохранить</button>
                            </div>
                        </div>
                @endif
            </form>
        </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection