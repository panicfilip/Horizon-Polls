<?php

namespace App;

use App\Choice;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Question extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $fillable = ['question_text', 'user_id', 'question_type', 'is_results_visible', 'active'];

    protected $sluggable = [
        'build_from' => 'question_text',
        'save_to' => 'slug'
    ];

    public function choices()
    {
        return $this->hasMany('App\Choice');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeGetActiveQuestions($query, $wheres=array(), $sort_field="questions.id", $sort_type="questions.desc"){
            
        return $query->leftJoin(\DB::raw('(
            SELECT question_id, COUNT(*) total_votes
            FROM votes) votes'), function($join)
        {
            $join->on('questions.id', '=', 'votes.question_id');
        })
        ->where(function($query) use ($wheres) {
            foreach( $wheres as $field=>$value){
                if( $value == null ){
                    continue;
                }
                $operators = "=";
                $query->where($field, $operators, $value);
            }
        })
        ->where("questions.active",1)
        ->select("questions.*", 'votes.total_votes')
        ->orderBy($sort_field, $sort_type)
        ->get();

    }

    public function scopeGetUnansweredQuestions($query, $sort_field="questions.id", $sort_type="questions.desc"){
            
        return $query->leftJoin('votes AS v', 'questions.id', '=', 'v.question_id')
                    ->whereNull("v.user_id")
                    ->where("questions.active",1)
                    ->where("questions.question_type",2)
                    ->select("questions.*")
                    ->orderBy($sort_field, $sort_type)
                    ->get();

    }

    public function scopeGetAnsweredQuestions($query, $sort_field="questions.id", $sort_type="questions.desc"){
        
        return $query->leftJoin('votes AS v', 'questions.id', '=', 'v.question_id')
                    ->where("v.user_id",\Auth::user()->id)
                    ->where("questions.active",1)
                    ->where("questions.question_type",2)
                    ->select("questions.*")
                    ->orderBy($sort_field, $sort_type)
                    ->get();
                    
    }
}
