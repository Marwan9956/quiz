@extends('quiz.quizLayout')

@section('Header', ucfirst($topic) . "  Quiz" )

@section('content')
    <hr>
    @include('component.messageAlert')
    <div class="d-flex flex-score">
        <div>
            <h3>{{$question->question}} </h3>
        </div>
        <div class="quiz-score">
            <p>Score is : {{session('score')}}</p>
        </div>
    </div>
    <!--
    <a href="{{url('/quiz/'. $question->subject_id.'/question?id='.$question->id)}}" class="btn btn-success"> Next Question </a>
    -->

    <form method="post" action="{{route('quiz.answerProsess' ,['subject_id' => $question->subject_id ,
                                                               'question_id' => $question->id])}}">
        @csrf
        @foreach($answers as $answer)
        <div class="form-check m-4">
            <label class="form-check-label" for="answer{{$answer->id}}">
            <input class="form-check-input" type="radio" name="answer" id="answer{{$answer->id}}" value="{{$answer->id}}">
            
                {{ucfirst($answer->answer_choice)}}
            </label>
        </div>
        @endforeach
        <input type="hidden" name="subject_id" value="{{$question->subject_id}}"/>
        <div class="d-flex justify-content-center">
            
            <button type="submit" name="question_id" value="{{$question->id}}" class="btn btn-success mt-5">Submit</button>
        </div>
    </form>
    
@endsection
