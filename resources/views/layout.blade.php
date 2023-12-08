<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel App - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center px-md-4 border-bottom mb-3 bg-white p-3 shadow-sm">
        <a href="{{ route('home.index') }}" class="me-md-auto fw-bolder text-dark text-decoration-none my-0">
            <h5 class="fw-bolder my-0 me-auto">Laravel Blog</h5>
        </a>
        <nav class="my-md-0 mb-md-2 my-2">
            <a class="text-decoration-none text-dark p-2" href="{{ route('home.index') }}">Home</a>
            <a class="text-decoration-none text-dark p-2" href="{{ route('home.contact') }}">Contact</a>
            <a class="text-decoration-none text-dark p-2" href="{{ route('posts.index') }}">Blog Posts</a>
            <a class="text-decoration-none text-dark p-2" href="{{ route('posts.create') }}">Add Post</a>

            @guest
                @if (Route::has('login'))
                    <a class="text-decoration-none text-dark p-2" href="{{ route('register') }}">Register</a>
                @endif
                <a class="text-decoration-none text-dark p-2" href="{{ route('login') }}">Login</a>
            @else
                <a class="text-decoration-none text-dark p-2" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout
                    ({{ Auth::user()->name }}) </a>
                <form id="logout-form" action="{{ route('logout') }} "method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </nav>
    </div>
    <div class="container">
        @if (session('status'))
            <div class="badge bg-success">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>

</html>
