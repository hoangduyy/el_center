<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>El Center Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="El Center is - Professional A unique and beautiful collection of UI elements">

    <!-- Favicon -->
    <link href="/client/assets/images/favicon.png" rel="icon" type="image/png">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="/client/assets/css/icons.css">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="/client/assets/css/uikit.css">
    <link rel="stylesheet" href="/client/assets/css/style.css">
    <link rel="stylesheet" href="/client/assets/css/tailwind.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'El center') }}</title>


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('style')
</head>

<body>

    <div id="wrapper" class="is-verticle">

        <!--  Header  -->
        <header class="is-transparent is-dark border-b backdrop-filter backdrop-blur-2xl" uk-sticky="cls-inactive: is-dark is-transparent border-b">
            <div class="header_inner">
                <div class="left-side">

                    <!-- Logo -->
                    <div id="logo">
                        <a href="/">
                            <img src="/client/assets/images/logo.png" alt="">
                            <img src="/client/assets/images/logo-light.png" class="logo_inverse" alt="">
                            <img src="/client/assets/images/logo-mobile.png" class="logo_mobile" alt="">
                        </a>
                    </div>

                    <!-- icon menu for mobile -->
                    <div class="triger" uk-toggle="target: #wrapper ; cls: is-active">
                    </div>

                </div>
                {{--<div class="right-side">--}}

                    {{--<!-- Header search box  -->--}}
                    {{--<form action="/course" method="get">--}}
                        {{--<div class="header_search"><i class="uil-search-alt"></i>--}}
                            {{--<input name="search" value="{{request()->get('search')}}" type="text" class="form-control" placeholder="Tìm kiếm khoá học ..." autocomplete="off">--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            </div>
        </header>

        <!-- Main Contents -->
        <div class="main_content">
            @yield('content')
        </div>

        <!-- sidebar -->
        <div class="sidebar">
            <div class="sidebar_inner" data-simplebar>

                <ul class="side-colored">
                    <li ><a href="/">
                            <ion-icon name="compass" class="bg-gradient-to-br from-purple-300 p-1 rounded-md side-icon text-opacity-80 text-white to-blue-500">
                            </ion-icon>
                            <span>Trang chủ</span>
                        </a>
                    </li>
                    {{--<li><a href="/blog">--}}
                            {{--<ion-icon name="newspaper" class="bg-gradient-to-br from-purple-300 p-1 rounded-md side-icon text-opacity-80 text-white to-blue-500">--}}
                            {{--</ion-icon>--}}
                            {{--<span>Blog</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li><a href="/course">
                            <ion-icon name="play-circle" class="bg-gradient-to-br from-yellow-300 p-1 rounded-md side-icon text-opacity-80 text-white to-red-500">
                            </ion-icon>
                            <span> Khóa học</span>
                        </a>
                    </li>
                    <li><a href="/tin-tuc">
                            <ion-icon name="play-circle" class="bg-gradient-to-br from-yellow-300 p-1 rounded-md side-icon text-opacity-80 text-white to-red-500">
                            </ion-icon>
                            <span>Tin tức</span>
                        </a>
                    </li>
                    <li><a href="/bai-viet">
                            <ion-icon name="play-circle" class="bg-gradient-to-br from-yellow-300 p-1 rounded-md side-icon text-opacity-80 text-white to-red-500">
                            </ion-icon>
                            <span>Bài viết</span>
                        </a>
                    </li>
                    @if (feGuard()->user())
                        <li><a href="{{ route('cart') }}">
                                <ion-icon name="film" class="side-icon md hydrated" role="img" aria-label="film">  </ion-icon>
                                <span>Giỏ hàng</span>
                            </a>
                        </li>
                    @endif
                </ul>

                <ul class="side_links" data-sub-title="">
                    <li>
                        <a href="/contact">
                            <ion-icon name="albums-outline" class="side-icon"></ion-icon>Liên hệ
                        </a>
                    </li>
                    @if (feGuard()->user())
                        @if (feGuard()->user()->status_test == \App\Models\User::STATUS_TESTED)
                        @else
                            <li>
                                <a href="{{ route('get.student.test') }}">
                                    <ion-icon name="albums-outline" class="side-icon"></ion-icon>Thực hiện test
                                </a>
                            </li>
                        @endif
                    @endif

                    @if (!feGuard()->check())
                        <li>
                            <a href="{{route('get.login')}}">
                                <ion-icon name="information-circle-outline" class="side-icon"></ion-icon>
                                Đăng nhập
                            </a>
                        </li>
                        <li>
                            <a href="{{route('get.register')}}">
                                <ion-icon name="information-circle-outline" class="side-icon"></ion-icon>
                                Đăng ký
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{route('get.profile')}}">
                                <ion-icon name="information-circle-outline" class="side-icon"></ion-icon>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{route('get.logout')}}" onclick="return confirm('Đăng xuất. Bạn có chắc không?')">
                                <ion-icon name="information-circle-outline" class="side-icon"></ion-icon>
                                Đăng xuất
                            </a>
                        </li>
                    @endif
                    </li>
                </ul>
            </div>

            <div class="side_overly" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></div>
        </div>

    </div>


    <!-- Javascript
    ================================================== -->
    <script src="/client/assets/libs/jquery-3.6.0.min.js"></script>
    <script src="/client/assets/js/uikit.js"></script>
    <script src="/client/assets/js/tippy.all.min.js"></script>
    <script src="/client/assets/js/simplebar.js"></script>
    <script src="/client/assets/js/custom.js"></script>
    <script src="/client/assets/js/bootstrap-select.min.js"></script>
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
    <script>
        const path = window.location.pathname;
        const menuItem = document.querySelector(
            `.side-colored a[href="${path}"]`
        );
        menuItem?.parentElement.classList.add("active");
    </script>


    @stack('script')

</body>


<!-- Mirrored from demo.foxthemes.net/El Center-v4.2/default/explore.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Jun 2021 06:48:04 GMT -->

</html>
