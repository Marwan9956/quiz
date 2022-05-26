<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * List all topics for quiz
 */
Route::get('/', function () {
    //return all list of topics 
})->name('home');

/**
 * Quiz questions based on subject id 
 */
Route::get('/quiz/{subject_id}/{question_id}' , function($subject_id , $question_id = 1){

})->name('quiz');



/**
 * Admin Routes for Adding topics and questions 
 */
Route::get('/admin' , function(){
    //return 
    echo 'hi';
});

Route::prefix('/admin/subject')->group(function(){
    //return list all subjects  with option to edit or delete 
    Route::get('/' , 'AdminController@show');
    
    Route::get('/add' , 'AdminController@add');
    
    Route::get('/edit/{id}' , 'AdminController@edit');
    //submiting editing
});

/**
 * Adding questions 
 */
Route::prefix('/admin/question')->group(function(){
    //list all question of subject 
    Route::get('/{subject_id}' , function($subject_id){
        return $subject_id;
    });

    Route::get('/{subject_id}/add' , function($subject_id){

    });

    Route::get('/{subject_id}/update' , function($subject_id){

    });
});

