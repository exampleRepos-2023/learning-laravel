@extends('layouts.app')

@section('title', $post['title'])

@section('content')

    @if ($post['is_new'])
        <div>A new blog post! using if</div>
    @else
        <div>Not a new blog post</div>
    @endif

    @unless ($post['is_new'])
        <div>it is a old post... unless</div>
    @endunless

    @isset($post['has_comments'])
        <div>The post has some comments... using isset</div>
    @endisset

    <h1>{{ $post['title'] }}</h1>
    <p>{{ $post['content'] }}</p>
@endsection
