@extends('layouts.app')

@section('content')

<!-- Main Contents -->
<div class="container p-0">

        <div class="bg-blue-600 md:rounded-b-lg md:-mt-8 md:pb-8 md:pt-12 p-5 pb-8 relative overflow-hidden" style="background: #1877f2;">

            <div class="lg:w-9/12 relative z-10">

                <div class="uppercase text-gray-200 mb-2 font-semibold text-sm">{{$data->level->name}}</div>
                <h1 class="lg:leading-10 lg:text-3xl text-white text-2xl leading-8 font-semibold">
                    {{$data->title}}
                </h1>
                <ul class="flex text-gray-200 gap-4 mt-4 mb-2">
                    <li class="flex items-center">
                        <span class="avg bg-yellow-500 mr-2 px-2 rounded text-white font-semiold">{{$data->rate}}</span>
                        <div class="star-rating text-yellow-400">
                            <?php $i = 1; ?>
                            @while($i <= $data->rate)
                                @if($i <= $data->rate)
                                    <ion-icon name="star"></ion-icon>
                                    @else
                                    <ion-icon name="star-half"></ion-icon>
                                    @endif
                                    <?php $i++ ?>
                                    @endwhile
                        </div>
                    </li>
                    {{--<li>--}}
                        {{--<ion-icon name="people-circle-outline"></ion-icon> {{$totalRegister}} Đã đăng ký--}}
                    {{--</li>--}}
                </ul>
                <ul class="lg:flex items-center text-gray-200">
                    <li> <span class="lg:block hidden mx-3 text-2xl">·</span> </li>
                    <li> Ngày tạo: {{date("d/m/Y", strtotime($data->created_at))}}</li>
                </ul>

            </div>

            <img src="/client/assets/images/courses/course-intro.png" alt="" class="-bottom-1/2 absolute right-0 hidden lg:block">

        </div>

        <div class="lg:flex lg:space-x-4 mt-4">
            <div class="lg:w-8/12 space-y-4">

                <div class="tube-card z-20 mb-4 overflow-hidden uk-sticky" uk-sticky="cls-active:rounded-none ; media: 992 ; offset:70">
                    <nav class="cd-secondary-nav extanded ppercase nav-small">
                        <ul class="space-x-3" uk-scrollspy-nav="closest: li; scroll: true">
                            <li class="uk-active"><a href="#Overview" uk-scroll>Tổng quan</a></li>
                        </ul>
                    </nav>
                </div>


                <!-- course description -->
                <div class="tube-card p-5" id="Overview">

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold mb-1"> Thông tin </h3>
                            <p>
                                {{$data->description}}
                            </p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-1"> Thông tin chi tiết</h3>
                        </div>
                        <div>
                            <p> {!! $data->content !!} </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- course intro Sidebar -->
            <div class="lg:w-4/12 space-y-4 lg:mt-0 mt-4">

                <div uk-sticky="top:600;offset:; offset:90 ; media: 1024">
                    <div class="tube-card p-5" uk-sticky="top:600;offset:; offset:90 ; media: @s">

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col space-y-2">
                                <div class="text-3xl font-semibold"> {{$data->number_of_hours}} </div>
                                <div> SỐ GIỜ HỌC </div>
                                <ion-icon name="time" class="text-lg" hidden></ion-icon>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <div class="text-3xl font-semibold"> {{$data->lectures ?? 0}}</div>
                                <div> SỐ BÀI HỌC </div>
                                <ion-icon name="people-circle" class="text-lg" hidden></ion-icon>
                            </div>
                        </div>
                        <hr class="-mx-5 border-gray-200 my-4">
                        <h4 hidden> COURSE INCLUDES</h4>

                        <div class="-m-5 divide-y divide-gray-200 text-sm">
                            <div class="flex items-center px-5 py-3">
                                <ion-icon name="play-outline" class="text-2xl mr-2"></ion-icon> bắt đầu:  {{date("d/m/Y", strtotime($data->start_date))}}
                            </div>
                            <div class="flex items-center px-5 py-3">
                                <ion-icon name="key-outline" class="text-2xl mr-2"></ion-icon> học phí: {{number_format($data->price)}} đ
                            </div>
                            <div class="flex items-center px-5 py-3">
                                <ion-icon name="download-outline" class="text-2xl mr-2"></ion-icon> số lớp: {{$totalClass}}
                            </div>
                        </div>

                    </div>
                    <div class="mt-4">
                        <a href="/course/{{$data->slug}}/classes" class="flex items-center justify-center h-9 px-6 rounded-md bg-blue-600 text-white"> Đăng ký học </a>
                    </div>
                </div>

                <div class="tube-card p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="text-lg -mb-0.5 font-semibold"> Các khoá học khác </h4>
                        </div>
                    </div>
                    <div class="p-1">
                        @foreach($relatedCourses as $course)
                        <a href="/course/{{$course->slug}}" class="-mx-3 block hover:bg-gray-100 p-2 rounded-md">
                            <div class="flex items-center space-x-3">
                                <img src="{{asset($course->thumbnail) ?? 'https://vnpi-hcm.vn/wp-content/uploads/2018/01/no-image-800x600.png'}}" alt="" class="h-12 object-cover rounded-md w-12">
                                <div class="line-clamp-2 text-sm font-medium">
                                    {{$course->title}}
                                </div>
                            </div>
                        </a>
                        @endforeach

                    </div>
                    <a href="/course" class="hover:bg-gray-100 -mb-1.5 mt-0.5 h-8 flex items-center justify-center rounded-md text-blue-400 text-sm">
                        Xem tất cả
                    </a>
                </div>

            </div>
        </div>

    </div>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v13.0&appId=252550996753713&autoLogAppEvents=1" nonce="AQB9GR4Q"></script>
@endsection
