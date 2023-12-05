<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title fw-bold">{{ $title }}</h5>
        <h6 class="card-subtitle text-muted mt-2">{{ $subtitle }}</h6>
    </div>
    <ul class="list-group list-group-flush">
        @if (is_a($items, 'Illuminate\Support\Collection'))
            @foreach ($items as $item)
                <li class="list-group-item text-truncate">
                    {{ $item }}
                </li>
            @endforeach
        @else
            {{ $items }}
        @endif
    </ul>
</div>
