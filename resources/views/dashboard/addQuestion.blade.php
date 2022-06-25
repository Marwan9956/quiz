@extends('dashboard.layout')

@section('Header', 'Add ' .  ucfirst($topic->title) . ' Question')

@section('content')
    @include('component.messageAlert')
    
    <form method="post" 
        action="{{ route('question.store' , ['subject_id' => $topic->id ])}}">
        @csrf
        <div class="form-group">
            <label for="question">{{ ucfirst($topic->title) }} Question</label>
            <textarea class="form-control" name="question" rows="3" cols="3" autofocus="autofocus">{{old('question')}}</textarea>
        </div>
        

        <section id="answers">
            @for($i = 1 ; $i <= 4 ;$i++)
                <div class="form-group">
                    <label for="" >Choice  {{ $i }}</label>
                    <input class="form-control" name="choice{{$i}}" placeholder="Write Choice answer {{$i}}" value="{{old('choice'. $i)}}">
                </div>
            @endfor
        </section>


        <div class="form-group">
            <label for="correctAnsNum">Correct Answer </label>
            <select id="correctAnsNum" name="correctAnsNum" class="form-control" required>
                <option value="#">#</option>
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{$i}}" 
                            @php 
                                $selected = '';
                                if(old('correctAnsNum') == strval($i)){
                                    $selected = 'selected';
                                }
                               
                            @endphp  {{$selected}}>
                        {{$i}}  
                    </option>
                    
                @endfor
                
            </select>
           
        </div>

        <button type="submit" class="btn btn-primary btn-block"> Add Question </button>
    </form>
@endsection
