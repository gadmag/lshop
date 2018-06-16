@foreach($blocks as $block)
    <div class="block block-right-bottom block-id-{{$block->id}}">
        <h3 class="dualline">{{$block->title}}</h3>
        <div class="block-content">
            {!! $block->body !!}
        </div>
    </div>
@endforeach
