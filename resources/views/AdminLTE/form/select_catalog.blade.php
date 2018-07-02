
<option @if($catalog) {{($catalog->parent_id == $catItem['item']->id)? 'selected' : ''}} @endif value="{{$catItem['item']->id}}">{{str_repeat('-', $catItem['item']->depth)}} {{$catItem['item']->name}}</option>
@if($catItem['children'])

    @foreach($catItem['children'] as  $catItem)
       @include('AdminLTE.form.select_catalog', ['$catItem' => $catItem, 'catalog' => $catalog? $catalog : ''])
    @endforeach
@endif