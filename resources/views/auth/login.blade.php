@extends('layouts.app')

@section('content')
    <form class="grid gap-3" action="{{ route('login') }}" method="post">
        @csrf

        <div class="row">
            <label for="e-mail" class="form-label">E-mail</label>
            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }} "
                value="{{ old('email') }}"name="email" required>
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="row">
            <label for="name" class="form-label">Password</label>
            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }} " type="password"name="password"
                required>
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="row mt-3">
            <div class="form-check">
                <input type="checkbox" value="{{ old('remember') ? 'checked' : '' }}" class="form-check-input"
                    name="remember">
                <label class="form-check-label" for="remember"> Remember Me</label>
            </div>
        </div>

        <div class="row">
            <button class="btn btn-primary mt-3">Login</button>
        </div>
    </form>
@endsection
