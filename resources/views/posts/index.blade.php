@extends('layout')

@section('title', 'Blog Posts')

@section('content')
    <div class="row">
        <div class="col-8">

            @forelse ($posts as $key => $post)
                <h3>
                    @if ($post->trashed())
                        <del>
                    @endif
                    <a class="text-decoration-none {{ $post->trashed() ? 'text-muted' : '' }}"
                        href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                    </del>
                </h3>
                <p>{{ $post->content }}</p>

                <x-updated date="{{ $post->created_at->diffForHumans() }}" name="{{ $post->user->name }}">
                </x-updated>

                @if ($post->comments_count)
                    <strong>{{ $post->comments_count }} comments</strong>
                @else
                    <p>No comments</p>
                @endif

                </p>

                <div class="mb-3">
                    @auth
                        @if (!$post->trashed())
                            @can('update', $post)
                                <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                            @endcan

                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" class="d-inline" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input class="btn btn-primary" type="submit" value="Delete">
                                </form>
                            @endcan
                        @endif
                    @endauth
                </div>
            @empty
                <div>There are no posts</div>
            @endforelse
        </div>
        <div class="col-4">
            <div class="container">
                <div class="row">
                    <x-card title="Most commented" subtitle="What people are currently talking about">
                        @slot('items')
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item text-truncate">
                                    <a class="text-decoration-none" href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        @endslot
                    </x-card>
                </div>

                <div class="row mt-2">
                    <x-card :items="collect($mostActive)->pluck('name')" title="Most active users" subtitle="Users with most posts writen">
                    </x-card>
                </div>

                <div class="row mt-2">
                    <x-card :items="collect($mostActive)->pluck('name')" title="Most active last month"
                        subtitle="Users with most posts writen last month">
                    </x-card>
                </div>
            </div>
        </div>
    </div>
@endsection
