@extends('dashboard.layout')

@section('Header', 'Add Topic')

@section('content')
    @include('component.messageAlert')
    
    <form method="post" action="{{ url('/admin/subject/add')}}">
        @csrf
        <div class="form-group">
            <label for="topicTitle">Topic title</label>
            <input name="topicTitle" type="text" class="form-control" placeholder="Right Topic title here" >
        </div>

        <button type="submit" class="btn btn-primary btn-block"> Submit </button>
    </form>
@endsection