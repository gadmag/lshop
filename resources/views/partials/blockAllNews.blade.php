<div class="block block-all-news">
    {{--    {!! dd($news->articles->first()) !!}--}}

    @foreach($allNews->chunk(3) as $chunk)
        <div class="row">
            @foreach($chunk as $news)


                <div class="col-md-4">
                    <div class="item-all-news">
                        <h4 class="catalog-name">{{$news->name}}</h4>
                        @if($news->articles->first())
                            @if(file_exists(public_path('storage/files/media/k2/items/cache/'.$news->articles->first()->image_md5.'_S.jpg')))

                                <img class="thumbnail img-responsive"
                                     src="{{asset('storage/files/media/k2/items/cache/'.$news->articles->first()->image_md5.'_S.jpg')}}"
                                     alt="Картинка">

                            @endif
                            @if($news->articles->first()->files->first())

                                <img class="thumbnail img-responsive"
                                     src="{{asset('storage/files/400x300/'.$news->articles->first()->files()->first()->filename)}}"
                                     alt="Картинка">

                            @endif
                            <div class="news-title"><a
                                        href="{{route('news.show',['alias' => $news->articles->first()->id.'-'.$news->articles->first()->alias])}}">{{$news->articles->first()->title}}</a>
                            </div>
                            <div class="description">{!! str_limit(strip_tags($news->articles->first()->description),150)!!}</div>
                            <div class="pubdate"><span
                                        class="fa fa-calendar"></span> {{$news->articles->first()->published_at}}
                            </div>
                        @endif
                    </div>
                </div>

            @endforeach
        </div>
    @endforeach

</div>