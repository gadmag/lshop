@if(Auth::guard('web')->check())
<p>
    You are logged in as a <strong>user</strong>
</p>
    @else
    <p class="text-danger">
        You are logged out  as a <strong>user</strong>
    </p>
@endif

@if(Auth::guard('admin')->check())
    <p>
        You are logged in as a <strong>admin</strong>
    </p>
@else
    <p class="text-danger">
        You are logged out  as a <strong>admin</strong>
    </p>
@endif