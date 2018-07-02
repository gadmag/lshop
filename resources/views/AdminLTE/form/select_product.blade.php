
<option @if($product->catalogs) {{in_array($catItem['item']->id, $product->catalogs->pluck('id')->toArray())? 'selected' : ''}} @endif  value="{{$catItem['item']->id}}">{{str_repeat('-', $catItem['item']->depth)}} {{$catItem['item']->name}}</option>
@if($catItem['children'])

    @foreach($catItem['children'] as  $catItem)
       @include('AdminLTE.form.select_product', ['$catItem' => $catItem])
    @endforeach
@endif