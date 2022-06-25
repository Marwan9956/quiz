<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    protected $table = "answers";

    protected $primaryKey = "id";

    //protected $dateFormat = 'U';

    protected $fillable = ['answer_choice' , 'answer_correct', 'question_id'];

    public $timestamps = true;

    /**
     * to get the subject of the question
     * one to many -- inverse 
     */
    public function question(){
        return $this->belongsTo('App\question');
    }

    
}
