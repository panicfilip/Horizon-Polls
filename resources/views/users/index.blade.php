@extends('layouts.master')

@section('content')
   
    <h1>Users</h1><a href="/users/create" class="btn btn-default">Add New User</a>
    @if (count($users) > 0)
        <div class="users">
                @foreach ($users as $user)
                    <h3>
                        <a href="{!! action('UserController@profile', [$user->email]) !!}">{{ $user->email }}</a>
                    </h3>
                    @if($user->active == 1)
                        <a href="{{ action('UserController@deactivate', ["id"=>$user->id]) }}" class="btn btn-warning">Deactivate user</a>
                    @else
                        <a href="{{ action('UserController@activate', ["id"=>$user->id]) }}" class="btn btn-success">Activate user</a>
                    @endif

                    @if($user->is_admin == 1)
                        <a href="{{ action('UserController@regular', ["id"=>$user->id]) }}" class="btn btn-info">Make regular user</a>
                    @else
                        <a href="{{ action('UserController@admin', ["id"=>$user->id]) }}" class="btn btn-primary">Make admin user</a>
                    @endif
                    <a href="{{ action('UserController@destroy', ["id"=>$user->id]) }}" class="btn btn-danger" onclick="if( confirm('Are you sure you want to delete this user?') == false){ return false;}">Delete user</a>
                @endforeach
        </div>
    @else
        <h3>No Users</h3>
    @endif
@endsection
