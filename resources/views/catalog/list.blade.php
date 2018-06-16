
    <div class="block our-products">
{{--                    {!! dd($catalogs) !!}--}}
        <div class="block-content-middle row">
        @foreach ($catalogs as $catalog)

                <div class="@if($loop->index == 3) col-md-offset-2 @endif col-sm-4 item-rows">
                    <div class="img-product">
                        <div class="product-title">

                        <a href="/{{empty($catalog->alias->alias_url)? "catalog/$catalog->id" : $catalog->alias->alias_url}}">
                            {{--<img class="img-responsive" src="../img/product1.jpg" alt="">--}}
                            @foreach($catalog->files as $file)
                               <img class="img-responsive" src="{{asset('storage/files/1250x700/'.$file->filename)}}" alt="{{$catalog->name}}">
                            @endforeach
                        </a>
                        <div class="out-product-item-wrapper">
                            <div class="title-product"> <a href="/{{empty($catalog->alias->alias_url)? "catalog/$catalog->id" : $catalog->alias->alias_url}}">{{$catalog->name}}</a></div>

                        </div>
                    </div>
                    </div>
                </div>

        @endforeach
                </div>

        <div class="clearfix"></div>


    </div><!-- our products -->