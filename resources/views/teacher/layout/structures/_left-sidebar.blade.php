<aside class="left-sidebar" data-sidebarbg="skin5">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('t.tkb') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">TKB</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('t.profile') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Hồ sơ</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('t.logout') }}"
                       onclick="return confirm('Đăng xuất. Bạn có chắc chắn không?')">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
