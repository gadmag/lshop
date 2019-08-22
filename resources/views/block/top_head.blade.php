@foreach($blocks->where('region', 'top_head') as $block)
    <div class="block box block-{{$block->region}} block-id-{{$block->id}} block-{{$block->css_class}} @if($loop->last){{'last'}}@endif">
        <div class="block-container">
            <div class="block-body">
                {!! $block->body !!}
            </div>
        </div>
    </div>
@endforeach