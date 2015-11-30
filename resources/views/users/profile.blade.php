@extends('layouts.master')

@section('content')
    <h1>All polls by {{ $user->email }}</h1>

    <div class="row">
        <h2>Public Polls</h2>

        @include('includes.polls')

        <div class="clearfix"></div>

    </div>

    <div class="row">
        <h2>Private Polls</h2>

        @if (count($private) > 0)
            @foreach ($private as $question)
                @include('includes.private')
            @endforeach
        @else
            <h3>No Private Polls</h3>
        @endif
        
@endsection
