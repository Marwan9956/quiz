<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    //table name
    protected $table = 'subjects';
    //primary key
    protected $primaryKey = 'id';
    //dateFormat
    
    //fillable columns 
    protected $fillable = ['title'];

    //timestamps
    public $timestamps = true;

    /**
     * Get Question of subject
     */
    public function questions(){
        return $this->hasMany('App\question' , 'subject_id' , 'id');
    }
}
