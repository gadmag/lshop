@if($specials->count() > 0)
    <div class="last block block-special">
        <h2 class="title-head mb-5 py-2 title text-center">Акции</h2>
        <div class="container">
            <product-list :products="{{$specials}}"></product-list>
        </div>
    </div>
@endif
