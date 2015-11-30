<?php

namespace App\Repositories;

use App\Question;
use App\User;
use Carbon\Carbon;

class QuestionRepository
{
    public function getAll()
    {
        return Question::latest()->get();
    }


    public function getQuestionsByUser(User $user)
    {
        return $user->questions;
    }

    public function getPublicQuestionsByUser($user)
    {
        return $user->questions()
            ->latest()
            ->active()
            ->where('question_type', '=', 1)
            ->get();
    }

    public function getPrivateQuestionsByUser($user)
    {
        return $user->questions()
            ->latest()
            ->active()
            ->where('question_type', '=', 2)
            ->get();
    }
}
