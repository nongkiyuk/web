<ul class="sidebar-menu" data-widget="tree">
    <li class="header">Periode Aktif</li>
    <li>
        <a href="{{ route('place.index') }}">
            <i class="fa fa-list"></i>
            <span> Places </span>
        </a>
    </li>
    <li>
        <a href="{{ route('user.index') }}">
            <i class="fa fa-users"></i>
            <span> Users </span>
        </a>
    </li>
    <li>
        <a href="{{ route('notification.index') }}">
            <i class="fa fa-bell"></i>
            <span> Notification </span>
        </a>
    </li>
    <li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i>
            <span> {{ __('Logout') }}</span>
        </a>
    </li>
</ul>