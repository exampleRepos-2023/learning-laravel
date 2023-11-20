@if ($loop->even)
    <div style="background-color: silver">{{ $key }}.{{ $post['title'] }}</div>
@else
    <div>{{ $key }}.{{ $post['title'] }}</div>
@endif
