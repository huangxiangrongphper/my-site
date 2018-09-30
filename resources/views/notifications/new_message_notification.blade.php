<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    <a href="{{$notification->unread() ? '/notifications/'.$notification->id.'?redirect_url=/inbox/'.$notification->data['dialog'] : '/inbox/'.$notification->data['dialog']}}">
        {{ $notification->data['name'] }} 给你发了一条私信🙈 <span class="pull-right">{{ $notification->created_at->format('Y-m-d H:i:s') }}</span>
    </a>
</li>
