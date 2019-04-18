<!-- slider start -->
<div class="fnc-slider example-slider">
    <div class="fnc-slider__slides">
        @foreach($slides as $slide)
            <div class="fnc-slide  @if ($loop->index == 0)m--active-slide @endif ">
                <div class="fnc-slide__inner">
                    @if($slide->files()->exists())
                        <img class="img-responsive"
                             src="{{asset('storage/files/'.$slide->files()->first()->filename)}}"
                             alt="">
                    @endif
                    <div class="description">{!! $slide->body !!}</div>
                </div>
            </div>
        @endforeach
    </div>
    <nav class="fnc-nav">
        <div class="fnc-nav__bgs">
            @foreach($slides as $slide)
                <div class="fnc-nav__bg @if($loop->index == 0) m--active-nav-bg @endif "></div>
            @endforeach
        </div>
        <div class="fnc-nav__controls">
            @foreach($slides as $slide)
                <button class="fnc-nav__control">
                    <span class="fnc-nav__control-progress"></span>
                    {{$slide->title}}
                </button>
            @endforeach

        </div>
    </nav>
</div>