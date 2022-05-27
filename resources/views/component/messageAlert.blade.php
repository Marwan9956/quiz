
<!-- Success Component --> 
@if(session()->has('success'))
    <div class="alert alert-success"> {{ session()->get('success') }}</div>
@endif
<!-- error Component --> 
@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger"> {{ $error }}</div>
    @endforeach
@endif