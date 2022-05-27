@extends('dashboard.layout')

@section('title' , 'Topic')

@section('Header', 'Topics')

@section('content')
    <!-- Display All topics with ability to edit and delete  -->
    @include('dashboard.topicsTable')

    <!-- Button to go to add topic-->
@endsection