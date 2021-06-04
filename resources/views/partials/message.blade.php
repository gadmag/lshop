@if(Session::has('flash_message'))
    <div class="container">
        @alert(['type' => session('message_type')?:'success'])
        {{session('flash_message')}}
        @endalert
    </div>
@endif
@if($errors->any())
    <div class="container">
        @alert(['type' => 'danger'])
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endalert
    </div>
@endif