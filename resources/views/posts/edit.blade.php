@extends('layout')

@section('title', 'Update Post')

@section('content')
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('posts._form')
        <div class="row mt-2"><input class="btn btn-primary" type="submit" value="Update"></div>
    </form>
@endsection
