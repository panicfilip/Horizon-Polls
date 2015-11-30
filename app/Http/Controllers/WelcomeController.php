<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\QuestionRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Question;

class WelcomeController extends Controller
{
    public function __construct(QuestionRepository $questions)
    {
        $this->questions = $questions;
    }

    public function index()
    {   

        $where["questions.question_type"] = 2;
        $data['public_questions'] = Question::GetActiveQuestions($where)->take(3);

        $where["questions.question_type"] = 1;
        $data['private_questions'] = Question::GetActiveQuestions($where)->take(3);

        $data['archived_questions'] = Question::where("active",0)->get()->take(3);

        return view('home', $data);
    }
}
