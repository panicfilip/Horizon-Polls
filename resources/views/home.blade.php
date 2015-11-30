@extends('layouts.master')

@section('content')

        @if( Auth::check())
            <h2>Public Polls</h2>

            @if (count($public_questions) > 0)
                @foreach ($public_questions as $question)
                    @include('includes.poll')
                @endforeach
            @else
                <h3>No Public Polls</h3>
            @endif

            <div class="clearfix"></div>

            <br>
            <a href="/public-polls">View More Polls</a>
        @endif

        @if( Auth::check() && Auth::user()->is_admin == 1)
            <h2>Private Polls</h2>

            @if (count($private_questions) > 0)
                @foreach ($private_questions as $question)
                    @include('includes.poll')
                @endforeach

                <br>
                <a href="/private-polls">View More Polls</a>
            @else
                <h3>No Private Polls</h3>
            @endif

            <h2>Archived Polls</h2>

            @if (count($archived_questions) > 0)
                @foreach ($archived_questions as $question)
                    @include('includes.poll')
                @endforeach

                <br>
                <a href="/archived-polls">View More Polls</a>
            @else
                <h3>No Archived Polls</h3>
            @endif
            
        @endif

@endsection
