@foreach($blocks->where('region', 'footer_bottom') as $block)
    <div class="block block-{{$block->region}} block-id-{{$block->id}} {{$block->css_class}}">
        <div class="block-container">
            <h2>{{$block->title}}</h2>
            <div class="block-body">
                {!! $block->body !!}
            </div>
        </div>
    </div>
@endforeach
