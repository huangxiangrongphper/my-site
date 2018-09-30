<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    <a href="/notifications/{{$notification->id}}/register">点击标示已读</a>
        {{ $notification->data['name'] }}
    </a>关注了你.👏 <span class="pull-right">{{ $notification->created_at->format('Y-m-d H:i:s') }}</span>
</li>
