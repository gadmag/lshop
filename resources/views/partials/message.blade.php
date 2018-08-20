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

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>