<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\subject ;
use App\question;
use App\answer;
use App\Exceptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Session;

class QuizController extends Controller
{
    private $generalError;
    
    public function __construct(){
        $this->generalError = 'Unexpected Error call admin';
    }

    /**
     * Show:
     * 
     * 
     * @param 
     * 
     * @return 
     */
    public function show(){
        $data = subject::all();
        
        return view('quiz.mainPage')->with(['data' => $data]);
    }

    /**
     * 
     */
    public function processQuestion(Request $req){
        $num = 1;
        
        $req->validate([
            "answer" => "required",
            "question_id" => "required",
            "subject_id"  => "required"
        ]);

        /**
         *Increment based on answer
         * 
         */
        $answer = answer::where("id" , $req->answer)->get();
        
        if($answer[0]->answer_correct){
            Session::increment('score' , $incrementBy = 10);
        }
        
        
        $url = url('/quiz'. '/' . $req->subject_id .'/question?id='. $req->question_id);
        return redirect()->to($url);
    }

    /**
     * 
     */
    public function displayQuestion($subject_id , Request $req){
        try{
            $question_id = $req->query('id');
            /**
             * Init Score 
             */
            if(!Session::has('score')){
                Session::put('score' , 0);
            }
            
            if(empty($question_id)){
                $question = question::where("subject_id",$subject_id)->first();
            }else{
                $testQuestion = question::findOrFail($question_id);
                
                if($testQuestion->subject_id != $subject_id){
                    throw new ModelNotFoundException() ;
                }
                $question = $this->getNextQuestion($subject_id , $question_id);
                
                if(empty($question)){
                    /**
                     *  perform score 
                     */
                    $score =   Session::get('score');
                    $topic =   subject::where("id" , $subject_id)->get();

                    $data = [
                        'score'   => $score,
                        'topic'   => $topic[0]
                    ];
                    Session::put('score' , 0);  
                    return view('quiz.finalScore')->with($data);
                }
            }
            $answers = $question->answers()->get();
            $topic   = $question->subject()->first()->title;
            
            $data = [
                'question' => $question,
                'answers'  => $answers,
                'topic'  => $topic
            ];
            
            
            return view('quiz.question')->with($data);

        }catch(ModelNotFoundException $e){
            return redirect()->back()->withErrors('Error : Topic is not correct');
        }catch(ErrorException $e){
            return redirect()->back()->withErrors('Error : General error call admin');
        }catch(Exception $e){
            return redirect()->back()->withErrors([$this->generalError]);
        }
        
        
    }


    private function getNextQuestion($subject_id , $question_id){
        $questions = question::where("subject_id" , $subject_id)->get();
        $condition = false;
        for($i = 0 ; $i < count($questions); $i++){
            if($condition){
                return $questions[$i];
            }
            if($questions[$i]->id == $question_id){
                $condition = true;
            }
        }
        return "";
    }


    private function isCorrectAnswer($answer , $question_id){

    }

    private function getSession($name){
        if(Session::has('score')){
            
        }else{
            //init session
        }
    }
}
