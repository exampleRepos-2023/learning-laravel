@extends('layout')

@section('title', $post->title)

@section('content')
    <h1>{{ $post->title }}

        <x-badge :show="now()->diffInMinutes($post->created_at) < 90" type="primary">
            New Post!
        </x-badge>

    </h1>

    <p>{{ $post->content }}</p>

    <x-updated date="{{ $post->created_at->diffForHumans() }}" name="{{ $post->user->name }}"></x-updated>
    <x-updated date="{{ $post->updated_at->diffForHumans() }}">Updated</x-updated>

    <h4>Comments</h4>

    @forelse ($post->comments as $comment)
        <p>{{ $comment->content }} </p>
        <x-updated date="{{ $comment->created_at->diffForHumans() }}"></x-updated>
    @empty
        <p>No comments yet!</p>
    @endforelse
@endsection
