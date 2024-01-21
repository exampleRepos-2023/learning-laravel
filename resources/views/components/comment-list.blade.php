@forelse ($comments as $comment)
    <p>{{ $comment->content }} </p>

    <x-updated date="{{ $comment->created_at->diffForHumans() }}" name="{{ $comment->user->name }} "
        userId="{{ $comment->user->id }}">
    </x-updated>

    <x-tags :tags="$post->tags"></x-tags>
@empty
    <p>No comments yet!</p>
@endforelse
