@extends('layout')

@section('title', 'Create Post')

@section('content')
    <form class="d-grid gap-2" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('posts._form')
        <div class="row">
            <input class="btn btn-primary" type="submit" value="Create">
        </div>
    </form>
@endsection
