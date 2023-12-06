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
        <x-card :items="collect($mostActive)->pluck('name')" title="Most active last month" subtitle="Users with most posts writen last month">
        </x-card>
    </div>
</div>
