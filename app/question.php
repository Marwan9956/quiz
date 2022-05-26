<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    protected $table = "questions";

    protected $primaryKey = "id";

    protected $dateFormat = 'U';

    protected $fillable = ['question' , 'subject_id'];

    public $timestamps = true;

    /**
     * to get the subject of the question
     * one to many -- inverse 
     */
    public function subject(){
        return $this->belongsTo('App\subject');
    }

    /**
     * To get the answers of choices  
     */
    public function answers(){
        return $this->hasMeny('App\answer');
    }
}
