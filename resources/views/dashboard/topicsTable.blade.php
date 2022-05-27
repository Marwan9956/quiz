<!--  Table List All Topics in Quiz App -->

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID     </th>
            <th scope="col">First </th>
            <th scope="col">    </th>
        </tr>
    </thead>
    <tbody>
        @if(count($subjects) > 0)
            @foreach ($subjects as $subject)
                <tr>
                    <th scope="row">{{ $subject->id }}</th>
                    <td class="mainTd">{{$subject->title}}</td>
                    <td>
                        <a class="btn btn-warning" href="#"> Edit   </a>
                        <a class="btn btn-danger"  href="#"> Delete </a>
                    </td>
                </tr>
            @endforeach    
        @endif
    </tbody>
</table>
<a class="btn btn-primary btn-block" href="{{ url('/admin/subject/add')}}">Add Topic</a>

   