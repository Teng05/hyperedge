<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['quiz_id','question_text','choice_a','choice_b','choice_c','choice_d','correct_answer','points'];

    public function quiz() { return $this->belongsTo(Quiz::class); }
}
