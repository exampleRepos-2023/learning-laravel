@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p>Added {{ $post->created_at->diffForHumans() }}</p>

    @if (now()->diffInHours($post->created_at) < 5)
        <div class="alert alert-info">This post was created less than 5 hour ago</div>
    @endif
@endsection
