@extends('layouts.master')

@section('content')
    @if ($question->active)
        @include('includes.poll')
    @else
        @include('includes.private')
    @endif
@endsection
