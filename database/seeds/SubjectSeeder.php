<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Array contain all topics
         */
        $subjects =[ 'Javascript' , 'PHP' , 'HTML' , 'CSS' , 'SQL' ];

        $questions = [
            "Javascript" => [
                'Inside which HTML element do we put the JavaScript?' => [
                    'scripting' => 0 ,
                    'script' => 1
                ],
                'Where is the correct place to insert a JavaScript?' => [
                    'body' => 1 ,
                    'p'    => 0
                ],
                'What is the correct syntax for referring to an external script called "xxx.js"?' => [
                    'script href' => 0 ,
                    'script src' => 1
                ],
                'The external JavaScript file must contain the script tag. ?' => [
                    'true' => 0 ,
                    'false' => 1
                ],
                'How do you write "Hello World" in an alert box?' => [
                    'alert("hello world")' => 1 ,
                    'msg("hello world")' => 0
                ]
            ],
            "PHP" => [
                'What does PHP stand for?' => [
                    'PHP : Hypertext Preprocessor' => 1 ,
                    'Personal Hypertext Processor' => 0
                ],
                'How do you write "Hello World" in PHP?' => [
                    'Hello world' => 0 ,
                    'echo hello world'    => 1
                ],
                'All variables in PHP start with which symbol?' => [
                    '&' => 0 ,
                    '$' => 1
                ],
                'What is the correct way to end a PHP statement?' => [
                    '.' => 0 ,
                    ';' => 1
                ],
                'How do you get information from a form that is submitted using the "get" method?' => [
                    '$_GET[]' => 1 ,
                    'Request.Form' => 0
                ]
            ],
            "HTML" => [
                'What does HTML stand for?' => [
                    'Hyper test markup language' => 1 ,
                    'Home tool markup language' => 0
                ],
                'Choose the correct HTML element for the largest heading?' => [
                    '<h1>'    => 1 ,
                    '<h6>'    => 0
                ],
                'What is the correct HTML element for inserting a line break?' => [
                    '<break>' => 0 ,
                    '<br>' => 1
                ],
                'Choose the correct HTML element to define important text' => [
                    '<important>' => 0 ,
                    '<strong>' => 1
                ],
                'What is the correct HTML for creating a hyperlink?' => [
                    '<a href>' => 1 ,
                    '<a url>' => 0
                ]
            ],
            "CSS" => [
                'What does CSS stand for?' => [
                    'Cascading style sheets' => 1 ,
                    'Computer style sheets' => 0
                ],
                'What is the correct HTML for referring to an external style sheet?' => [
                    '<style src>'    => 0 ,
                    '<link rel>'    => 1
                ],
                'Where in an HTML document is the correct place to refer to an external style sheet?' => [
                    'in the <head>' => 1 ,
                    'in the end of document' => 0
                ],
                'Which HTML tag is used to define an internal style sheet?' => [
                    '<css>' => 0 ,
                    '<style>' => 1
                ],
                'How do you insert a comment in a CSS file?' => [
                    '/* * \/' => 1 ,
                    "'" => 0
                ]
            ],
            "SQL" => [
                'What does SQL stand for?' => [
                    'Structured Query Language' => 1 ,
                    'Structured Question language' => 0
                ],
                'Which SQL statement is used to update data in a database?' => [
                    'SAVE'    => 0 ,
                    'UPDATE'    => 1
                ],
                'Which SQL statement is used to delete data from a database?' => [
                    'DELETE' => 1 ,
                    'REMOVE' => 0
                ],
                'Which SQL statement is used to add new data in a database?' => [
                    'ADD new' => 0 ,
                    'INSERT new' => 1
                ]
            ]
        ];
        $phpQuestions        = [];
        $htmlQuestions       = [];
        $cssQuestions        = [];
        $sqlQuestions        = [];

        /**
         * Insert Subjects
         */
        for($i = 0; $i < count($subjects); $i++){
            DB::table('subjects')->insert([
                'title' => $subjects[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
        }

        /**
         * Add Questions
         */
        $index = 0;
        foreach($questions as $subject => $question){
            foreach($question as $ques => $answer){
                DB::table('questions')->insert([
                    'question' => $ques,
                    'subject_id' => $index + 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                $questionID = DB::getPdo()->lastInsertId();
                foreach($answer as $choice => $correct){
                    DB::table('answers')->insert([
                        'answer_choice' => $choice,
                        'answer_correct'=> $correct,
                        'question_id'=> $questionID,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
            $index +=1;

        }
        
    }
}
