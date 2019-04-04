@foreach ($designItem->chunk(4) as $designChunk)
    <div class="row">
        @foreach($designChunk as $design)
            <div class="col-sm-6 col-md-3">
                <div class="card bg-inverse text-white product-item">
                        @if($design->files()->first())
                            <img class="card-img"
                                 src="{{asset('storage/files/400x300/'.$design->files()->first()->filename)}}"
                                 alt="Картинка">
                        @endif

                        <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                            <h4 class="card-title">
                                <a class="text-white" href="{{route('design.show', ['id' => $design->id])}}">{{$design->title}}</a>
                            </h4>

{{--                            <div class="product-link"><a class="text-uppercase btn btn-outline-light"--}}
{{--                                                                     href="{{route('design.show', ['id' => $design->id])}}">Подробнее</a>--}}
{{--                            </div>--}}
                        </div>
                </div>

            </div>
        @endforeach
    </div>
@endforeach
