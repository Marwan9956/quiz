@extends('quiz.quizLayout')

@section('Header', ucfirst($topic->title) . "  Quiz" )

@section('content')
    <hr>
    @include('component.messageAlert')
    <h3>Your Score is :  <i>{{$score}}</i></h3>
    <a href="{{route('quiz')}}" class="btn btn-success">Back </a>
    
@endsection
