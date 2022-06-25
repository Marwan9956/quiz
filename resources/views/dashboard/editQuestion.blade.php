@extends('dashboard.layout')

@section('Header', 'Update ' .  ucfirst($question->title) . ' Question')

@section('content')
    @include('component.messageAlert')
    
    <form method="post" 
        action="{{ route('question.editSubmit' , [
            'question_id' => $question->id ,
            'subject_id'  => $question->subject_id
            ])}}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="question">{{ ucfirst($question->title) }} Question</label>
            <textarea class="form-control" name="question" rows="3" cols="3" autofocus="autofocus">{{$question->question}}</textarea>
        </div>
        

        <section id="answers">
            
            
            @for($i = 0 ; $i < count($answers); $i++)
                
                <div class="form-group">
                    <label for="" >Choice  {{$i}}</label>
                    <input class="form-control" name="{{ 'choice' . $i}}"  value="{{$answers[$i]->answer_choice}}">
                </div>
                

            @endfor
        </section>

        <div class="form-group">
            <label for="correctAnsNum">Correct Answer </label>
            <select id="correctAnsNum" name="correctAnsNum" class="form-control" required>
                <option value="#">#</option>
                @for($i = 0; $i < count($answers); $i++)
                    <option value="{{$i}}" 
                            @php 
                                $selected = '';
                                if($answers[$i]->answer_correct){
                                    $selected = 'selected';
                                }
                               
                            @endphp  {{$selected}}>
                        {{$i}}  
                    </option>
                    
                @endfor
                
            </select>
           
        </div>

        <button type="submit" class="btn btn-primary btn-block"> update Question </button>
    </form>
@endsection
