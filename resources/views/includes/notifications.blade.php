@forelse ($notifications as $notification)
    <li class="dropdown-item">
        <strong>{{ $notification->title }}</strong><br>
        <span>{{ $notification->body }}</span>
        <small class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
    </li>
@empty
    <li class="dropdown-item text-center">No notifications</li>
@endforelse