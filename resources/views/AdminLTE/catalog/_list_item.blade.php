<li class="">

    {{str_repeat('-', $catalog->depth)}} <a target="_blank" href="{{action('CatalogController@show', [$catalog->id])}}">{{$catalog->name}}</a>


    <a style="display: inline-block" href="{{action('Admin\CatalogController@edit',[$catalog->id])}}"
       class="" title="Редактировать"
       data-toggle="tooltip">
        <i class="fa fa-edit"></i>
    </a>

    <!-- Delete Button -->

    <form style="display: inline-block" action="{{ url('admin/catalogs/'.$catalog->id) }}" method="POST">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}

        <button style="display: inline-block" type="submit" class="btn-nonstyle delete" data-toggle="tooltip"
                title="Удалить">
            <i class="fa fa-trash"></i>
        </button>
    </form>

</li>
@foreach($catalog->children->sortBy('order') as $catalog)
    <ul class="">@include('AdminLTE.catalog._list_item', $catalog)</ul>
@endforeach


