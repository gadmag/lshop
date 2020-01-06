
<div id="carouselLotus" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($slides as $slide)
            <div class="carousel-item @if ($loop->index == 0)active @endif">
                @if($slide->files()->exists())
                    <img src="{{asset('storage/files/'.$slide->files()->first()->filename)}}" class="d-block img-fluid w-100" alt="{{$slide->title}}">
                @endif
                <div class="img-overlay"></div>
                <div class="carousel-caption">{!! $slide->body !!}</div>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselLotus" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Назад</span>
    </a>
    <a class="carousel-control-next" href="#carouselLotus" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Вперед</span>
    </a>
</div>