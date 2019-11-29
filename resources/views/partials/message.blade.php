@if(Session::has('flash_message'))
    <div class="container">
        <div class="row">
            <div role="alert" class="alert alert-success w-100">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{session('flash_message')}}

            </div>
        </div>
    </div>
@endif