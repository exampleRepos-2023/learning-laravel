@extends('layout')

@section('title', $post->title)

@section('content')
    <div class="row">
        <div class="col-8">
            <h1>{{ $post->title }}

                <x-badge :show="now()->diffInMinutes($post->created_at) < 90" type="primary">
                    New Post!
                </x-badge>

            </h1>

            <p>{{ $post->content }}</p>

            <x-updated date="{{ $post->created_at->diffForHumans() }}" name="{{ $post->user->name }}"></x-updated>
            <x-updated date="{{ $post->updated_at->diffForHumans() }}">Updated</x-updated>
            <x-tags :tags="$post->tags"></x-tags>

            <p>Curretly read by {{ $counter }} people</p>
            <h4>Comments</h4>

            @forelse ($post->comments as $comment)
                <p>{{ $comment->content }} </p>
                <x-updated date="{{ $comment->created_at->diffForHumans() }}"></x-updated>
            @empty
                <p>No comments yet!</p>
            @endforelse
        </div>
        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>
@endsection
