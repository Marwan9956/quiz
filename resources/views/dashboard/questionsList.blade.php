@extends('dashboard.layout')

@section('title' , 'Questions')

@section('Header', 'Questions')

@section('content')
    <!-- message Box -->
    @include('component.messageAlert')
    <!-- List Questions on table   -->
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID             </th>
                <th scope="col">Question       </th>
                <th scope="col">Correct Answer </th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($questions) > 0)
                @php( $index = 0)
                @foreach ($questions as $question)
                <tr>
                    <th scope="row">{{ $question->id }}</th>
                    <td class="questionCol">{{ucfirst($question->question)}}</td>
                    @if(count($answers) > 0)
                        <td scope="row">{{$answers[$index]}}</td>
                    @else 
                        <td scope="row">No Answers Given </td>
                    @endif
                    <td >
                        <a class="btn btn-warning" 
                        href="{{route('question.editForm' ,[
                            'subject_id' => Request::segment(4),
                            'question_id' => $question->id
                        ])}}">
                            Edit 
                        </a>
                        <form Id="inlineForm" class="form-inline" method="POST" 
                        action="{{route('question.delete' , ['question_id' => $question->id])}}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-icon">
                            delete
                            </button>
                        </form>
                    </td>
                </tr>
                @php( $index += 1)
                @endforeach    
            @endif
        </tbody>
    </table>
    <a class="btn btn-primary btn-block" 
    href="{{route('question.add' , ['subject_id' => Request::segment(4)]) }}">
    Add Question
    </a>
@endsection





   