@extends('layouts.master')

@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Register
            </div>
            <div class="panel-body">
                @include('errors.form')

                <form method="POST" action="/join">
                    {!! csrf_field() !!}

                    <!--<div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" id="username" class="form-control" required>
                    </div >-->

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control" required>
                    </div >

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div >

                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="confirm-password" class="form-control" required>
                    </div >

                    <div >
                        <button type="submit" class="btn btn-default">Sign Up</button>
                    </div >
                </form>
            </div>
        </div>
    </div>
@endsection
