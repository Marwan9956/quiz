<!--  Table List All Topics in Quiz App -->

@include('component.messageAlert')

<!-- -->
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID     </th>
            <th scope="col">Topic </th>
            <th scope="col">    </th>
        </tr>
    </thead>
    <tbody>
        @if(count($subjects) > 0)
        
            @foreach ($subjects as $subject)
                <tr>
                    <th scope="row">{{ $subject->id }}</th>
                    <td class="mainTd">{{ucfirst($subject->title)}}</td>
                    <td >
                        <a class="btn btn-dark"
                           href="{{route('question.list' , ['subject_id' => $subject->id ])}}">
                            List questions
                        </a>
                        <a class="btn btn-secondary" 
                          href="{{route('question.add' , ['subject_id' => $subject->id ])}}">
                            add Question
                        </a>
                        <a class="btn btn-warning" 
                           href="{{ route('subject.edit', [ 'id' => $subject->id ]) }}">
                            Edit 
                        </a>
                        <form Id="inlineForm" class="form-inline" method="POST" action="{{ route('subject.delete', [ 'id' => $subject->id ]) }}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-icon">
                              delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach    
        @endif
    </tbody>
</table>
<a class="btn btn-primary btn-block" href="{{ url('/admin/subject/add')}}">Add Topic</a>

   