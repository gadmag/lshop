<li class="item-link">
    <div class="inner-item">
        <div class="left-item">
            <a target="_blank" href="{{action('CatalogController@show', [$catalog->alias?:$catalog->id])}}">{{$catalog->name}}</a>
        </div>

        <div class="right-item">
            <a class="btn btn-sm btn-success" href="{{action('CatalogController@show', [$catalog->alias?:$catalog->id])}}">
                <i class="fa fa-eye"></i>
            </a>
            <a href="{{action('Admin\CatalogController@edit',[$catalog->id])}}"
               class="btn btn-primary btn-sm" title="Редактировать"
               data-toggle="tooltip">
                <i class="fa fa-edit"></i>
            </a>

            <!-- Delete Button -->

            <form style="display: inline-block" action="{{ url('admin/catalogs/'.$catalog->id) }}" method="POST">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}

                <button style="display: inline-block" type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                        title="Удалить">
                    <i class="fa fa-trash"></i>
                </button>
            </form>

        </div>
    </div>
</li>
@foreach($catalog->children->sortBy('order') as  $catalog)
   <ol class="sub-menu">@include('AdminLTE.catalog._list_item', $catalog)</ol>
@endforeach


