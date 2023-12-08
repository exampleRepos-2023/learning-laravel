<div class="mb-2 mt-2">
    @auth
        <form method="POST" class="d-grid gap-2" action="{{ $route }}">
            @csrf

            <div class="row">
                <textarea class="form-control" type="text" name="content"></textarea>
            </div>

            <div class="row">
                <button class="btn btn-primary" type="submit">Add comment</button>
            </div>
        </form>
        <x-errors />
    @else
        <a class="btn btn-primary" href="{{ route('login') }}">Sign-in</a> to post comments!
    @endauth
</div>
<hr>
