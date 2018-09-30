<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    <a href="#">
       亲爱的 :{{ $notification->data['name'] }}😘 恭喜您成为本站新的用户,在这里你可以和大家一起探讨各种PHP知识😋
    </a>
</li>
