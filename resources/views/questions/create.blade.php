@extends('layouts.master')

@section('content')
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Create a New Poll
            </div>
            <div class="panel-body">
                @include('errors.form')
                <div class="add-question">
                    <form class="form" action="/poll" method="post">
                        {{ csrf_field() }}
                        <div id="question" class="form-group">
                            <label for="question_text">Question</label>
                            <input type="text" name="question_text" id="question_text" class="form-control" required>
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
                            <label for="question_type">Type</label><br>
                            <label>
                                <input type="radio" name="question_type" value="2" checked>Public
                            </label>
                            <label>
                                <input type="radio" name="question_type" value="1">Private
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="question_type">Visible results</label><br>
                            <label>
                                <input type="radio" name="is_results_visible" value="1" checked>Yes
                            </label>
                            <label>
                                <input type="radio" name="is_results_visible" value="0">No
                            </label>
                        </div>

                        <div class="choices">
                            <div id="choice_1 form-group" class="choice form-group">
                                <label for="choice1">Choice 1</label>
                                <input type="text" name="choices[]" id="choice1" class="form-control" required>
                            </div>
                            <div id="choice_2" class="choice form-group">
                                <label for="choice2">Choice 2</label>
                                <input type="text" name="choices[]" id="choice2" class="form-control" required>
                            </div>
                        </div>
                        <button type="button" id="add-choice" class="btn btn-primary">+</button>
                        <button type="button" id="remove-choice" class="btn btn-danger">-</button>
                        <br><br>
                        <button type="submit" class="btn btn-default">New Poll</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
