<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Choice;
use App\Question;
use App\Vote;
use App\Repositories\QuestionRepository;
use App\Http\Requests\QuestionRequest;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    protected $questions;

    public function __construct(QuestionRepository $questions)
    {
        $this->middleware('auth', ['only' => ['create', 'store']]);
        $this->questions = $questions;
    }

    public function index()
    {
        return view('questions.index')->with('questions', $this->questions->getAll());
    }

    public function unanswered()
    {
        $data['questions'] = Question::GetUnansweredQuestions();
        $data['title'] = "Unanswered";

        return view('questions.index')->with($data);
    }

    public function answered()
    {

        $data['questions'] = Question::GetAnsweredQuestions();
        $data['title'] = "Answered";

        return view('questions.index')->with($data);
    }

    public function create()
    {
        return view('questions.create');
    }

    public function edit($id)
    {
        $data["question"] = Question::findOrFail($id);
        $data["choices"] = Choice::where("question_id",$id)->get();

        return view('questions.edit')->with($data);
    }

    public function update($id, Request $request)
    {
        $question = Question::findOrFail($id);
        foreach($request->choices as $choice) {
            $choiceModels[] = new Choice(['choice_text' => $choice]);
        }
        $data = $request->all();
        $data["user_id"] = \Auth::user()->id;

        Choice::where("question_id",$id)->delete();

        $question->update($data);

        $question->choices()->saveMany($choiceModels);

        session()->flash('flash_msg', 'You have successfully added a poll.');

        return redirect('/');
    }

    public function archive($id)
    {
        $question = Question::findOrFail($id);
                
        $question->active=0;
        $question->save();

        return redirect("/")->with('messages', 'Poll was deactivated');
    }

    public function activate($id)
    {
        $question = Question::findOrFail($id);
                
        $question->active=1;
        $question->save();

        return redirect("/")->with('messages', 'Poll was activated');
    }

    public function store(QuestionRequest $request)
    {
        foreach($request->choices as $choice) {
            $choiceModels[] = new Choice(['choice_text' => $choice]);
        }
        $data = $request->all();
        
        $data["user_id"] = \Auth::user()->id;
        
        $question = Question::create( $data );

        $question->choices()->saveMany($choiceModels);

        session()->flash('flash_msg', 'You have successfully edited a poll.');

        return redirect('/');
    }

    public function vote(Request $request, $id)
    {
        $vote = Vote::where("question_id",$id)->where("user_id",\Auth::user()->id)->first();
        if($vote){
            session()->flash('flash_msg', 'You have already voted for this poll.');
            return redirect('/');
        }

        $question = Question::find($id);

        $slug = $question->slug;

        $this->validate($request, [
            $slug => 'required'
        ], ['required' => 'Select an option to vote.']);

        $choice = $question->choices()->where('choice_text', '=', $request->input($slug));
        $choice->increment('votes');

        $data["user_id"]        = \Auth::user()->id;
        $data["question_id"]    = $question->id;
        $data["choice_id"]      = $choice->first()->id;
        Vote::create($data);

        session()->flash('flash_msg', 'You have voted successfully.');

        return redirect('/');
    }

    public function show(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        return view('questions.single')->with('question', $question);
    }

    public function publicQuestions()
    {
        $where["questions.question_type"] = 2;
        $data['questions'] = Question::GetActiveQuestions($where);
        $data['title'] = "Public";

        return view('questions.index')->with($data);
    }

    public function privateQuestions()
    {
        $where["questions.question_type"] = 1;
        $data['questions'] = Question::GetActiveQuestions($where);
        $data['title'] = "Private";

        return view('questions.index')->with($data);
    }

    public function archivedQuestions()
    {
        $data['questions'] = Question::where("active",0)->get();
        $data['title'] = "Archived";

        return view('questions.index')->with($data);
    }
    
    public static function delete($id)
    {
        $question = Question::findOrFail($id);
        
        $question->delete();

        return redirect("/")->with('messages', 'Poll was deleted');
    }
}
