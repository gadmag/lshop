<div class="row">
    @foreach ($designItem->chunk(4) as $designChunk)
        <div class="row">
            @foreach($designChunk as $design)
                <div class="col-sm-6 col-md-3">
                    <div class="product-item">
                        <div class="thumbnail">
                            @if($design->files()->first())
                                <img class="img-responsive" src="{{asset('storage/files/400x300/'.$design->files()->first()->filename)}}" alt="Картинка">
                            @endif

                            <div class="caption">
                                <div class="product-name text-center"><a class="" href="{{route('design.show', ['id' => $design->id])}}">{{$design->title}}</a></div>

                                <div class="product-link text-center"><a class="button action primary"
                                                                         href="{{route('design.show', ['id' => $design->id])}}">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endforeach
</div>