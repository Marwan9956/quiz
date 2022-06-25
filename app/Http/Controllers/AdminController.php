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

class AdminController extends Controller
{
    private $generalError;
    
    public function __construct(){
        $this->generalError = 'Unexpected Error call admin';
    }

    /**
     * Display dashboard main page 
     */
    public function show(){
        return view('dashboard.layout');
    }

    /**
     * List all topics 
     */
    public function listTopic(){
        $subjects = subject::all();
        
        return view('dashboard.subject')->with(['subjects' => $subjects ]);
    }

    /**
     * Display topic form 
     */
    public function add(){
        return view('dashboard.addTopics');
    }

    /**
     * Store new topic 
     * 
     * @param Request $req 
     *  
     * @return  / back to the same page with success or errors 
     */
    public function storeTopic(Request $req){
        $topicTitle =  $req->input('topicTitle');
        $req->validate([
            'topicTitle' => 'required|max:20'
        ]);
        try{
            if(subject::where('title' , '=' , $topicTitle)->count() > 0){
                throw new \ErrorException('Title is already there');
            }

            
            
            $subject = new subject;
            $subject->title = $topicTitle;
            $subject->save();
            
            return redirect()->back()->with(['success' =>'Topic Saved Successfuly ']);
        }catch(\ErrorException $e){
            return redirect('/admin/subject/add')->withErrors([$e->getMessage()]);
        }catch(\Exception $e){
            return redirect('/admin/subject/add')->withErrors([$this->generalError]);
        }
        
        
    }

    /**
     * delete topic 
     * to delete topic by id 
     * 
     * @param  int $id  
     * 
     * @return   alert message 
     */
    public function deleteTopic($id){
        try{
            $subject = subject::find($id);
            if(empty($subject)){
                throw new \ErrorException('id number is not correct');
            }

            if($subject->delete()){
                return redirect()->back()->with(['success' => 'Item get deleted']);
            }else{
                throw new \ErrorException('Error : Delete Failed ');
            }
            
        }catch(\ErrorException $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }catch(\Exception $e){
            return redirect()->back()->withErrors([$this->generalError]);
        }
    }


    /**
     * Show form to edit the topic 
     * 
     * @param int $id 
     * 
     * @return view form to edit the topic 
     */
    public function edit($id){
        try{
            $topic = subject::findOrFail($id);
            
            return view('dashboard.editTopics')->with(['topic' => $topic]);
        }catch(ModelNotFoundException $e){
            return redirect('/admin/subject')->withErrors(['Error : topic not found']);
        }catch(\Exception $e){
            return redirect('/admin/subject')->withErrors(['Error : System Error call admin']);
        }
    }

    /**
     * edit the topic 
     * 
     * @param int $id   
     * @param Request $req  
     * 
     * @return message
     */
    public function editTopic($id , Request $req){
        $req->validate([
            'topicTitle' => 'required|max:20'
        ]);

        try{
            $topic = subject::findOrFail($id);
            $topicTitle = $req->input('topicTitle');
           

            if(subject::where('title' , '=' , $topicTitle)->count() > 0){
                throw new \ErrorException('Title is already there');
            }

            $topic->title = $topicTitle;
            if($topic->save()){
                return redirect('/admin/subject')->with(['success' =>'Topic adjusted Successfuly']);
            }else{
                throw \ErrorException('Error : Server error we could not save your edit');
            }

        }catch(ModelNotFoundException $e){
            return redirect()->back()->withErrors(['Error : topic not found']);
        }catch(\ErrorException $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }catch(\Exception $e){
            return redirect()->back()->withErrors([$this->generalError]);
        }
    }



    /**
     * addQuestion : display form for adding question 
     * 
     * @param int subjectID
     * 
     * @return view form for adding question 
     */
    public function addQuestion($subjectID ){
        try{
            $topic = subject::findOrFail($subjectID);

            return view('dashboard.addQuestion')->with([
                'topic'  =>  $topic
            ]);

        }catch(ModelNotFoundException $e){
            return redirect('/admin/subject')->withErrors(['Error : Topic not found']);
        }catch(Exception $e){
            return redirect('/admin/subject')->withErrors([$this->generalError]);
        }
        
    }


    /**
     * Store Question
     * 
     * @param int subjectID
     * @param Request req
     * 
     * @return redirect user with success or error message 
     */
    public function storeQuestion($subjectID , Request $req){
        //0- check if question is already there
        $req->validate([
            'question'      => 'required|max:310|unique:questions',
            'correctAnsNum' => 'required|integer|between:1,4',
            'choice1'       => 'required',
            'choice2'       => 'required'
        ], [
            'correctAnsNum.required' => 'Correct Answer not been chosen',
            'correctAnsNum.integer'  => 'Correct Answer has to be number',
            'correctAnsNum.between'  => 'Correct Answer has to be number between 1 and 4 '
        ]);
        try{
            $topic = subject::findOrFail($subjectID);
            $choices = [];
            for($i = 1; $i <= 4 ; $i++ ){
                if(empty($req->input('choice'.$i))){
                    continue;
                }
                array_push($choices , $req->input('choice'.$i));
            }

            //1- check choices is different
            if($this->checkChoices($choices)){
                throw new \ErrorException('Error : Choices is not unique');
            }
            

            //Add question 
            DB::beginTransaction();

            $question = new question;
            $question->question = $req->input('question');
            $question->subject_id= $subjectID;
            $question->save();
            $question_id = $question->id;

            
            
            //store Answers
            for($i = 1 ; $i <= count($choices); $i++){
                $choice = new answer;
                $choice->question_id = $question_id;
                $choice->answer_choice = $choices[$i-1];

                if($req->input('correctAnsNum') == $i){
                    $choice->answer_correct = true;
                }else{
                    $choice->answer_correct = false;
                }

                $choice->save();
            }
            
           
            
            DB::commit();

            return redirect()->back()->with(['success' => 'Question has been added successfully']);

        }catch(ModelNotFoundException $e){
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(['Error: Topic is not Correct']);
        }catch(\ErrorException $e){
            DB::rollback();
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->withInput()->withErrors([$this->generalError]);
        }
         
         
         
    }



    /**
     * Private Function
     * Check if choices is not unique
     * 
     * @param array
     * 
     * @return boolean    
     */
    private function checkChoices($arr){
        for($i = 0; $i < count($arr); $i++){
            for($j = $i+1; $j < count($arr); $j++){
                if(strcasecmp($arr[$i] , $arr[$j]) == 0 ){
                    return true;
                }
            }
        }
        return false;
    }



    /**
     * Display question list of specific topic 
     * 
     * @param int subject_id
     * 
     * @return view with question list
     */
    public function showQuestions($subject_id){
        // return list of questions about the subject or topic id
        try{
            $questionsList = subject::findOrFail($subject_id)->questions()->get();
            $answers = [];
            
            
            
            foreach($questionsList as $question){
                //$ans = question::find($question->id)->answers()->get();
                
                $ans = $question->answers()->get();
                
                foreach($ans as $currunt){
                    
                    if($currunt->answer_correct){
                        array_push($answers , $currunt->answer_choice);
                        break;
                    }
                }
            }

            
            $data = [
                'questions'  => $questionsList ,
                'answers'    => $answers , 
                'subject_id' => ''
            ];
            return view('dashboard.questionsList')->with($data);
            //return to view with question list and answer arrays 
        }catch(ModelNotFoundException $e){
            return redirect()->back()->withInput()->withErrors(['Error: Topic is not Correct']);
        }catch(ErrorException $e){
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }catch(Exception $e){
            return redirect()->back()->withInput()->withErrors([$this->generalError]);
        }
        
    }

    /**
     * editQuestionForm:
     * display form to edit question
     * 
     * @param int $subjectId 
     * @param int $questionId
     * 
     * return view of form to edit the question or sent you back with error message 
     */
    public function editQuestionForm($subjectId , $questionId){
        try{
            $subject = subject::findOrFail($subjectId);
            $question = question::findOrFail($questionId);
            $answers = $question->answers()->get();
            
            $data = [
                'subject'  => $subject , 
                'question' => $question,
                'answers'  => $answers
            ];
            
            return view('dashboard.editQuestion')->with($data);
        }catch(ModelNotFoundException $e){
            return redirect()->back()->withErrors('Error : Topic is not correct');
        }catch(ErrorException $e){
            return redirect()->back()->withErrors('Error : General error call admin');
        }catch(Exception $e){
            return redirect()->back()->withErrors([$this->generalError]);
        }
    }

    /**
     * editQuestionSubmit:
     * evaluate the data that been submited 
     * 
     * @param int $question_id
     * @param int $subject_id
     * 
     * return send to question list view with sucess message or return back with error message  
     */
    public function editQuestionSubmit($question_id , $subject_id , Request $req){
        try{
            $subject = subject::findOrFail($subject_id);
            $question = question::findOrFail($question_id);
            $answers = $question->answers()->get();
            
            //validate request
            $req->validate([
                'question'      => 'required|max:310',
                'correctAnsNum' => 'required',
                'choice0'       => 'required',
                'choice1'       => 'required'
            ], [
                'correctAnsNum.required' => 'Correct Answer not been chosen',
                'choice0.required'       => 'The first choice is required',
                'choice1.required'       => 'The second choice is required'
            ]);


            //begin transaction 
            DB::beginTransaction();
            
            //1-update  question 
            $question->question = $req->question;
            $question->save();

            
            
            //2-bring the answers and update their value and if they are correct or not 
            for($i = 0 ; $i < count($answers); $i++){
                $ans = answer::findOrFail($answers[$i]->id);
                $ans->answer_choice = $req['choice'.$i];
        
                if($req->correctAnsNum == strval($i)){
                    $ans->answer_correct = 1;
                }else{
                    $ans->answer_correct = 0; 
                }
                $ans->save();
            }

            

            //end transaction after you done updating 
            DB::commit();
            return redirect()->route('question.list' , ['subject_id' => $subject_id])->with(['success' => 'Question has been updated successfully']);
        }catch(ModelNotFoundException $e){
            DB::rollback();
            return redirect()->back()->withErrors('Error : Topic is not correct');
        }catch(ErrorException $e){
            DB::rollback();
            return redirect()->back()->withErrors('Error : General error call admin');
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors([$this->generalError]);
        }
    }


    /**
     * deleteQuestion:
     * delete question by question id
     * 
     * @param int $question_id
     * 
     * @return redirect to question list page with message 
     */
    public function deleteQuestion($question_id){
        try{
            $question = question::findOrFail($question_id);
            $subject_id = $question->subject_id;
            $answers = $question->answers;
            

            //Delete Answers related to the question 
            if(count($answers) > 0){
                foreach($answers as $ans){
                    $ans->delete();
                }
            }
            

            $question->delete();
            
            return redirect()->route('question.list' , ['subject_id' => $subject_id])->with(['success' => 'Question has been deleted successfully']);

        }catch(ModelNotFoundException $e){
            return redirect()->back()->withErrors('Error : Topic is not correct');
        }catch(ErrorException $e){
            return redirect()->back()->withErrors('Error : General error call admin');
        }catch(Exception $e){
            return redirect()->back()->withErrors([$this->generalError]);
        }
    }
    
}
