<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    
    protected $table = 'votes';
    
    protected $fillable = ['choice_id', 'user_id', 'question_id'];
}
