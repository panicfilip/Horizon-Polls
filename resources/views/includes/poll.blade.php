<div class="poll">
    @include('errors.form')

    <h3><a href="{!! action('QuestionController@show', ['id' => $question->id]) !!}">{{ $question->question_text }}</a></h3>
    <h5>by {{ $question->user->email }}</h5>
    <p>
        Posted on: {{ $question->created_at }}
    </p>
    
    <form action="{{ route('vote', $question->id) }}" method="post">
        {{ csrf_field() }}

        @foreach ($question->choices as $choice)
            <div class="choice">
                @if(Auth::user()->is_admin == 1)
                    {{ $choice->choice_text }}
                    Votes: {{ $choice->votes }}
                @else
                    <label for="{{ $choice->id }}">{{ $choice->choice_text }}</label>
                    <input type="radio" name="{{ $question->slug }}" id="{{ $choice->id }}" value="{{ $choice->choice_text }}">
                    @if($question->is_results_visible == 1)
                        Votes: {{ $choice->votes }}
                    @endif
                @endif
            </div>
        @endforeach
            @if(Auth::user()->is_admin == 0)
                <button type="submit" class="btn btn-default">Vote</button>
            @endif
        @if( Auth::user()->is_admin == 1 && $question->total_votes == 0)
            <a href="{{ action('QuestionController@edit', ["id"=>$question->id]) }}" class="btn btn-primary">Edit</a>
            @if($question->active == 1)
                <a href="{{ action('QuestionController@archive', ["id"=>$question->id]) }}" onclick="if( confirm('Are you sure you want to archive this poll?') == false){ return false;}" class="btn btn-warning">Archive</a>
            @else
                <a href="{{ action('QuestionController@activate', ["id"=>$question->id]) }}" class="btn btn-success">Activate</a>
            @endif
            <a href="{{ action('QuestionController@delete', ["id"=>$question->id]) }}" class="btn btn-danger" onclick="if( confirm('Are you sure you want to delete this poll?') == false){ return false;}">Delete Poll</a>
        @endif
    </form>
</div>
