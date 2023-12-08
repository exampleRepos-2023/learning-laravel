@extends('layout')

@section('title', 'Edit User')

@section('content')
    <form enctype="multipart/form-data" method="post" action="{{ route('users.update', ['user' => $user->id]) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img class="img-thumbnail avatar" src="{{ $user->image ? $user->image->url() : '' }}">

                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Upload a different photo</h6>
                    </div>
                    <input type="file" name="avatar" class="form-control">
                </div>
            </div>

            <div class="col-8">
                <div>
                    <label>Name: </label>
                    <input type="text" class="form-control" name="name" value=''>
                </div>

                <x-errors />

                <div class="mt-3">
                    <button class="btn btn-primary type="submit">Save Changes</button>
                </div>
            </div>
        </div>
    </form>

@endsection
