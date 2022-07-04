@extends('quiz.quizLayout')

@section('Header', 'Quiz App')

@section('content')
    @include('component.messageAlert')
        <div class="d-flex flex-row">
        @for($i = 0; $i < count($data); $i++)
                @if($i % 4 == 0)
                </div>
                <div class="d-flex flex-row">
                @endif
                <section class="quizContainer  p-2">
                    <h4>{{ucfirst($data[$i]->title)}}</h4>
                    <p>Test your knowledge about {{$data[$i]->title}}</p>
                    <a href="{{route('takeQuiz' , ['subject_id' => $data[$i]->id ]). '?id='}}" class="btn btn-success"> Take {{ucfirst($data[$i]->title)}} Quiz </a>
                </section>
            
        @endfor
        </div>
@endsection
