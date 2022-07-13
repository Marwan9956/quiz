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

Auth::routes([

    'register' => false, // Register Routes...
  
    'reset' => false, // Reset Password Routes...
  
    'verify' => false, // Email Verification Routes...
  
]);

/**
 * Main Route 
 */
Route::get('/' , function(){
    return redirect()->route('quiz');
});

/**
 * List all topics for quiz
 */
Route::get('/quiz' , 'QuizController@show')->name('quiz');

Route::get('/quiz/{subject_id}/question','QuizController@displayQuestion')->name('takeQuiz');

Route::post('/quiz/{subject_id}/question/{question_id}','QuizController@processQuestion')->name('quiz.answerProsess');





/**
 * Admin Routes for Adding topics  
 */
Route::get('/admin' , function(){
    return redirect('/admin/subject');
});

Route::prefix('/admin/subject')->group(function(){
    //return list all subjects  with option to edit or delete 
    Route::get('/' , 'AdminController@listTopic');
    
    Route::get('/add' , 'AdminController@add');

    Route::post('/add' , 'AdminController@storeTopic');
    
    
    Route::get('/edit/{id}' , 'AdminController@edit')->name('subject.edit');
    //submiting editing
});

/**
 * Admin Routes for Editing and deleting topics 
 */
Route::delete('/admin/subject/delete/{id}' , 'AdminController@deleteTopic')->name('subject.delete');

Route::PUT('/admin/subject/edit/{id}' , 'AdminController@editTopic')->name('subject.edit.submit');




/**
 * Adding questions 
 */
Route::prefix('/admin/question')->group(function(){
    //list all question of subject 
    Route::get('/subject/{subject_id}' , 'AdminController@showQuestions')->name('question.list');

    Route::get('/subject/{subject_id}/{question_id}/edit' , 'AdminController@editQuestionForm')->name('question.editForm');

    Route::get('/{subject_id}/add' , 'AdminController@addQuestion')->name('question.add');

    Route::post('/{subject_id}/add' , 'AdminController@storeQuestion')->name('question.store');

    
});

/**
 * Routes for Editing and deleting Questions 
 */

 Route::PUT('/admin/question/{question_id}/subject/{subject_id}' , 'AdminController@editQuestionSubmit')->name('question.editSubmit');
 Route::Delete('/admin/question/{question_id}' ,  'AdminController@deleteQuestion')->name('question.delete');

 

