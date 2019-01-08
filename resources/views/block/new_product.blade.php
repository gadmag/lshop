@foreach ($newProducts->chunk(4) as $productChunk)
    <div class="row">
        @foreach($productChunk as $product)
            <div class="col-sm-6 col-md-3">
                <product-list :product="{{$product}}"
                              @if($product->productSpecial()->exists())
                              pricespecial="@current_convert($product->productSpecial->price)"
                              persentprice="{{intval((($product->price - $product->productSpecial->price)/$product->price)*100)}}"
                              @endif
                              price="@current_convert($product->price)"
                              productlink="{{$product->alias? "products/$product->alias" : "products/$product->id"}}"
                              @if($product->files()->first())
                              imagepath="{{asset('storage/files/250x250/'.$product->files()->first()->filename)}}"
                        @endif

                ></product-list>

            </div>
        @endforeach
    </div>
@endforeach