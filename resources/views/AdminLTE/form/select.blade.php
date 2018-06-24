
<option {{($catalog->parent_id == $catItem['item']->id)? 'selected' : ''}} value="{{$catItem['item']->id}}">{{str_repeat('-', $catItem['item']->depth)}} {{$catItem['item']->name}}</option>
@if($catItem['children'])

    @foreach($catItem['children'] as  $catItem)
       @include('AdminLTE.form.select', ['$catItem' => $catItem, 'catalog' => $catalog])
    @endforeach
@endif