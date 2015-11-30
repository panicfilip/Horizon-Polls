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
                    {!! Form::model($question, array('action' => ['QuestionController@update', $question->id], 'method' => 'PATCH', "files"=>true)) !!}
                        {{ csrf_field() }}
                        <div id="question" class="form-group">
                            <label for="question_text">Question</label>
                            <input type="text" name="question_text" id="question_text" class="form-control" required value="{{ $question->question_text }}">
                        </div>

                        <input type="hidden" name="user_id" value="{{ $question->user_id }}">

                        <div class="form-group">
                            <label for="active">Active</label><br>
                            <label>
                                <input type="radio" name="active" value="1" <?php if($question->active == 1){ ?> checked <?php } ?>>Yes
                            </label>
                            <label>
                                <input type="radio" name="active" value="0" <?php if($question->active == 0){ ?> checked <?php } ?>>No
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="question_type">Type</label><br>
                            <label>
                                <input type="radio" name="question_type" value="2" <?php if($question->question_type == 2){ ?> checked <?php } ?>>Public
                            </label>
                            <label>
                                <input type="radio" name="question_type" value="1" <?php if($question->question_type == 1){ ?> checked <?php } ?>>Private
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="question_type">Visible results</label><br>
                            <label>
                                <input type="radio" name="is_results_visible" value="1" <?php if($question->is_results_visible == 1){ ?> checked <?php } ?>>Yes
                            </label>
                            <label>
                                <input type="radio" name="is_results_visible" value="0" <?php if($question->is_results_visible == 0){ ?> checked <?php } ?>>No
                            </label>
                        </div>

                        <div class="choices">
                            @for($i=0; $i<sizeof($choices); $i++)
                                <div id="choice_{{ $i+1 }}" class="choice form-group">
                                    <label for="choice{{ $i+1 }}">Choice {{ $i+1 }}</label>
                                    <input type="text" name="choices[]" id="choice{{ $i+1 }}" class="form-control" value="{{ $choices[$i]->choice_text }}" required>
                                </div>
                                
                            @endfor
                        </div>
                        <button type="button" id="add-choice" class="btn btn-primary">+</button>
                        <button type="button" id="remove-choice" class="btn btn-danger">-</button>
                        
                        <br><br>
                        <button type="submit" class="btn btn-default">Save Poll</button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
