<?php

namespace App;

use App\Question;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = [
        'question_id',
        'choice_text',
        'votes',
    ];

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
