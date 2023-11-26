@extends('layout')

@section('title', 'Blog Posts')

@section('content')
    @forelse ($posts as $key => $post)
        <p>
        <h3>
            <a class="text-decoration-none" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
        </h3>

        <p>Added {{ $post->created_at->diffForHumans() }}
            by {{ $post->user->name }}
        </p>

        @if ($post->comments_count)
            <strong>{{ $post->comments_count }} comments</strong>
        @else
            <p>No comments</p>
        @endif

        </p>


        <div class="mb-3">
            @can('update', $post)
                <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
            @endcan

            {{-- @cannot('delete', $post)
                <p>You can't delete this post</p>
            @endcannot --}}

            @can('delete', $post)
                <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-primary" type="submit" value="Delete">
                </form>
            @endcan
        </div>
    @empty
        <div>There are no posts</div>
    @endforelse
@endsection
