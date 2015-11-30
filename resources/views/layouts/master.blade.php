<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Create Your Own Polls</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
    </head>
    <body>

    @if ( session()->has('messages') )
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            @if ( is_array(session('messages')) )
                @foreach( session('messages') as $message) 
                    <li>{!! $message !!}</li>
                @endforeach        
            @else
                <li>{!! session('messages') !!}</li>
            @endif
        </div>
    @endif

    @if ( session()->has('error') )
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            @if ( is_array(session('error')) )
                @foreach( session('error') as $message) 
                    <li>{!! $message !!}</li>
                @endforeach        
            @else
                <li>{!! session('error') !!}</li>
            @endif
        </div>
    @endif


        <nav>
            <div class="container">

                <div class="logo">
                    <a href="/">Horizon Polls</a>
                </div>

                <div class="top-navigation">
                    @if( Auth::check())
                        @if(Auth::user()->is_admin == 1)
                            <a href="/users">Users</a>
                            <a href="/private-polls">Private Polls</a>
                            <a href="/archived-polls">Archived Polls</a>
                        @else
                            <a href="/unanswered">Unanswered Polls</a>
                            <a href="/answered">Answered Polls</a>
                        @endif
                    @endif
                    @if (Auth::check())
                        <a href="/public-polls">Public Polls</a>
                        @if(Auth::user()->is_admin == 1)
                            <a href="/poll/create">New Poll</a>
                        @endif
                        <a href="/logout">Logout</a>
                    @else
                        <a href="/join">Sign Up</a>
                        <a href="/login">Sign In</a>
                    @endif
                </div>
            </div>
        </nav>
        <div class="container">
            @include('includes/flash')
            @yield('content')
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
        <script src="{!! asset('js/scripts.js') !!}"></script>
    </body>
</html>
