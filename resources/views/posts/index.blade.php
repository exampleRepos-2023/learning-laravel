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
                    @if (!$post->trashed())
                        @can('update', $post)
                            <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                        @endcan

                        @can('delete', $post)
                            <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-primary" type="submit" value="Delete">
                            </form>
                        @endcan
                    @endif
                </div>
            @empty
                <div>There are no posts</div>
            @endforelse
        </div>
        <div class="col-4">
            <div class="container">
                <div class="row">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Most commented</h5>
                            <h6 class="card-subtitle text-muted mt-2">What people are currently talking about</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item text-truncate">
                                    <a class="text-decoration-none" href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Most active</h5>
                            <h6 class="card-subtitle text-muted mt-2">Users with most posts writen</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActive as $user)
                                <li class="list-group-item text-truncate fw-semibold">{{ $user->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Most active last month</h5>
                            <h6 class="card-subtitle text-muted mt-2">Users with most posts writen last month</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActiveLastMonth as $user)
                                <li class="list-group-item text-truncate fw-semibold">{{ $user->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
