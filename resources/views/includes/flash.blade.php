@if (session()->has('flash_msg'))
    <div class="alert">
        {{ session('flash_msg') }}
    </div>
@endif
