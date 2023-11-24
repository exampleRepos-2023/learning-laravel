@extends('layouts.app')

@section('content')
    <form class="grid gap-3" action="{{ route('register') }}" method="post">
        @csrf
        <div class="row">
            <label for="name" class="form-label">Name</label>
            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required
                value="{{ old('name') }}"name="name">
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

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

        <div class="row">
            <label for="name" class="form-label">Retype Password</label>
            <input class="form-control" type="password" name="password_confirmation" required>
        </div>

        <div class="row">
            <button class="btn btn-primary mt-3">Register</button>
        </div>
    </form>
@endsection
