{{--<menu id="nestable-menu">--}}
    {{--<button type="button" data-action="expand-all">Expand All</button>--}}
    {{--<button type="button" data-action="collapse-all">Collapse All</button>--}}
{{--</menu>--}}
{{--{!! dd($menuItems) !!}--}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="panel-heading">
    <a href="{{route('menus.create',['menu_type' => $type])}}" class="btn btn-primary">
        <i class="fa fa-plus"></i>
        Добавить пункт меню
    </a>
</div>
<div class="cf nestable-lists">
    <div class="dd" id="nestable">
        <ol class="dd-list">
            {{--@foreach($menuItems as $menuItem)--}}
               {{--@include('AdminLTE.menu._listMenuItem', $menuItem)--}}
            {{--@endforeach--}}
            @each('AdminLTE.menu._listMenuItem', $menuItems , 'menuItem')
        </ol>
    </div>

    <div class="clearfix"></div>
</div>


<textarea class="hidden" id="nestable-output"></textarea>
<div id="sortDBfeedback" style="border:1px solid #eaeaea; padding:10px; margin:15px;"></div>
<button id="save_nested" class="btn btn-default"><i class="fa fa-save"></i> Сохранить порядок</button>
{{--<a id="save_nested" class="btn btn-primary" href=""> <i class="fa fa-save"></i> Сохранить порядок</a>--}}
<p>&nbsp;</p>
