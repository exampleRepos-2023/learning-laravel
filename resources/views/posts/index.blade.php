@extends('layout')

@section('title', 'Blog Posts')

@section('content')
    @forelse ($posts as $key => $post)
        <p>
        <h3>
            <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
        </h3>

        <p>Added {{ $post->created_at->diffForHumans() }}</p>

        @if ($post->comments_count)
            <p>{{ $post->comments_count }} comments</p>
        @else
            <p>No comments</p>
        @endif

        </p>
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
            <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <input class="btn btn-primary" type="submit" value="Delete">
            </form>
        </div>
    @empty
        <div>There are no posts</div>
    @endforelse
@endsection
