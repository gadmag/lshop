<div class="container">
    <div class="row">
        @if(Session::has('flash_message'))
            <div class="alert alert-success {{Session::has('flash_message_important')? 'alert-important': ''}}">
                @if(Session::has('flash_message_important'))
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                @endif
                {{session('flash_message')}}
            </div>
        @endif

    </div>
</div>