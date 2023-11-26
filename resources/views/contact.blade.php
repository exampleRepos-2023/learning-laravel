@extends('layout')

@section('title', 'Contact page')

@section('content')
    <h1>Contact page</h1>
    <p>This is the content of the contact page</p>

    @can('home.secret')
        <a href="{{ route('secret') }}">Go to special contact page ></a>
    @endcan
@endsection
