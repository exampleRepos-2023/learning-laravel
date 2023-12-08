@extends('layout')

@section('title', 'Show User')

@section('content')

    <div class="row mb-3">
        <div class="col-4">
            <img class="img-thumbnail avatar" src="{{ $user->image ? $user->image->url() : '' }}">
        </div>

        <div class="col-8">
            <h3>{{ $user->name }}</h3>

            <x-comment-form route="{{ route('users.comments.store', ['user' => $user->id]) }}" />

            <x-comment-list :comments="$user->commentsOn" />
        </div>

    </div>

@endsection
