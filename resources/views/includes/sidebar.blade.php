<ul class="sidebar-menu" data-widget="tree">
    <li class="header">Periode Aktif</li>
    <li>
        <form id="logout-form" action="" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i>
            <span> {{ __('Logout') }}</span>
        </a>
    </li>
</ul>