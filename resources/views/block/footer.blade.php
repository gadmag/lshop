@foreach($blocks->whereRegion('footer')->get() as $block)
    <div class="block box block-{{$block->region}} block-id-{{$block->id}} {{$block->css_class}} @if($loop->last){{'last'}}@endif">
        <div class="block-container">
            <h2 class="text-center">{{$block->title}}</h2>
            <div class="block-body">
                {!! $block->body !!}
            </div>
        </div>
    </div>
@endforeach
