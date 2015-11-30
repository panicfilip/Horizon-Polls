@if (count($questions) > 0)
    @foreach ($questions as $question)
        @include('includes.poll')
    @endforeach
@else
    <h3>No Polls</h3>
@endif
