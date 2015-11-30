@extends('layouts.master')

@section('content')
    <h1>{{ $title }} Polls</h1>
    
    @include('includes.polls')
@endsection
