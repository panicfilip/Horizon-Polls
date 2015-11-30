@extends('layouts.master')

@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Create a New User
            </div>
            <div class="panel-body">
                @include('errors.form')
                <div class="add-question">
                    <form class="form" action="/users" method="post">
                        {{ csrf_field() }}
                        <div id="question" class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="active">Active</label><br>
                            <label>
                                <input type="radio" name="active" value="1" checked>Yes
                            </label>
                            <label>
                                <input type="radio" name="active" value="0">No
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="question_type">Admin</label><br>
                            <label>
                                <input type="radio" name="is_admin" value="1">Yes
                            </label>
                            <label>
                                <input type="radio" name="is_admin" value="0" checked>No
                            </label>
                        </div>

                        <button type="submit" class="btn btn-default">Create</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
