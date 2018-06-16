@foreach($blocks as $block)
    <div class="block block-right-top block-id-{{$block->id}}">
        @if($loop->first) <br> @else <h3 class="redline">{{$block->title}}</h3>  @endif
        <div class="block-content">
            {!! $block->body !!}
        </div>
    </div>
@endforeach
