<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\subject ;
use App\Exceptions;

class AdminController extends Controller
{
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
     * @param $req  request data
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
        }catch(Exception $e){
            return redirect('/admin/subject/add')->withErrors([$e->getMessage()]);
        }
        
        
    }

    public function edit($id){

    }

    
}
