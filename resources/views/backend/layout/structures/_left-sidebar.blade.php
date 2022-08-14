<aside class="left-sidebar" data-sidebarbg="skin5">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.dashboard') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Trang chủ</span>
                    </a>
                </li>

                @if (isAdmin())
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span class="hide-menu">Chi nhánh</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level" style="padding-left: 15px">
                            <li class="sidebar-item">
                                <a href="{{ route('be.branch.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span class="hide-menu">Quản lý chi nhánh</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('be.room.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span class="hide-menu">Quản lý phòng học</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.course.index') }}">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span class="hide-menu">Quản lý khóa học</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.class.index') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Quản lý lớp học</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.tkb.index') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Thời khóa biểu</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.order') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Quản lý đơn đăng kí</span>
                    </a>
                </li>

                @if (isAdmin())
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.staff.index') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Quản lý nhân viên</span>
                    </a>
                </li>
                @endif

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.teacher.index') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Quản lý giáo viên</span>
                    </a>
                </li>

                @if (isAdmin())
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.question.index') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Bộ câu hỏi</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Tin tức </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level" style="padding-left: 15px">
                        <li class="sidebar-item">
                            <a href="{{ route('be.new.index') }}" class="sidebar-link">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="hide-menu">Quản lý tin tức</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('be.post.index') }}" class="sidebar-link">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="hide-menu">Quản lý bài viết</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.contact.index') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Liên hệ</span>
                    </a>
                </li>

                @if (isManager())
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.profile') }}">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span class="hide-menu">Profile</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('be.logout') }}"
                        onclick="return confirm('Đăng xuất. Bạn có chắc chắn không?')">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
