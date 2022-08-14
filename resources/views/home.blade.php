@extends('layouts.app')

@section('content')

    <style>
        @media (min-width: 768px) {
            .is-desktop {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .is-desktop {
                display: none;
            }
        }
    </style>

    <!-- Slideshow -->
    <div class="uk-position-relative uk-visible-toggle overflow-hidden lg:-mt-20" tabindex="-1"
         uk-slideshow="animation: scale ;min-height: 200; max-height: 450 ;autoplay: t rue">

        <ul class="uk-slideshow-items rounded">
            <li>
                <div class="uk-position-cover" uk-slideshow-parallax="scale: 1.2,1.2,1">
                    <img src="/client/assets/images/hero-1.jpg" class="object-cover" alt="" uk-cover>
                </div>
                <div class="container relative md:p-20 md:mt-7 p-5 h-full">
                    <div uk-slideshow-parallax="scale: 1,1,0.8"
                         class="flex flex-col justify-center h-full w-full space-y-3">
                        <h1 uk-slideshow-parallax="y: 100,0,0"
                            class="lg:text-4xl text-2xl text-white font-semibold">Học từ những điều tốt nhất</h1>
                        <p uk-slideshow-parallax="y: 150,0,0"
                           class="text-base text-white font-medium pb-4 lg:w-1/2">
                            Chúng tôi có hơn 80 năm kinh nghiệm về giảng dạy tiếng Anh và được hơn 100 triệu người học
                            trên toàn thế giới tin tưởng mỗi năm.
                        </p>
                        <a uk-slideshow-parallax="y: 200,0,50" href="/course"
                           class="bg-opacity-90 bg-white py-2.5 rounded-md text-base text-center w-32">
                            Bắt đầu ngay
                        </a>
                    </div>
                </div>
            </li>
            <li>
                <div class="uk-position-cover" uk-slideshow-parallax="scale: 1.2,1.2,1">
                    <img src="/client/assets/images/hero-2.jpg" class="object-cover" alt="" uk-cover>
                </div>
                <div class="container relative md:p-20 md:mt-7 p-5 h-full">
                    <div uk-slideshow-parallax="scale: 1,1,0.8"
                         class="flex flex-col justify-center h-full w-full space-y-3">
                        <h1 uk-slideshow-parallax="y: 100,0,0"
                            class="lg:text-4xl text-2xl text-white font-semibold"> Learn from the best</h1>
                        <p uk-slideshow-parallax="y: 150,0,0"
                           class="text-base text-white font-medium pb-4 lg:w-1/2"> Choose from 130,000 online
                            video courses with new additions published every month </p>
                        <a uk-slideshow-parallax="y: 200,0,0" href="#"
                           class="bg-opacity-90 bg-white py-2.5 rounded-md text-base text-center w-32"> Get
                            Started </a>
                    </div>
                </div>
            </li>
        </ul>

        <ul class="uk-slideshow-nav uk-dotnav absolute bottom-0 left-0 m-7 lg:flex hidden"></ul>
    </div>

    <div class="container">

        <!--  course feature -->
        <div class="sm:my-4 my-3 flex items-end justify-between pt-3">
            <h2 class="text-2xl font-semibold"> Khóa học mới </h2>
        </div>

        <div class="relative -mt-3" uk-slider="finite: true">

            <div class="uk-slider-container px-1 py-3">
                <ul class="uk-slider-items uk-child-width-1-1@m uk-grid">
                    @foreach($newCourses as $item)
                        <li>
                            <a href="/course/{{$item->slug}}" class="uk-link-reset">
                                <div class="bg-white shadow-sm rounded-lg uk-transition-toggle md:flex">
                                    <div class="md:w-5/12 md:h-60 h-40 overflow-hidden rounded-l-lg relative">
                                        <img style="object-fit:cover"
                                             src="{{$item->thumbnail ?? 'https://vnpi-hcm.vn/wp-content/uploads/2018/01/no-image-800x600.png'}}"
                                             alt=""
                                             class="w-full h-full absolute inset-0 object-cover">
                                    </div>
                                    <div class="flex-1 md:p-6 p-4">
                                        <div class="font-semibold line-clamp-2 md:text-xl md:leading-relaxed">
                                            {{$item->title}}
                                        </div>
                                        <div class="line-clamp-2 mt-2 md:block hidden">
                                            {{ strlen($item->description) > 200 ? substr($item->description, 200) . '...' : $item->description  }}
                                        </div>
                                        <div style="height: 75px;" class="is-desktop"></div>
                                        <div class="mt-1 flex items-center justify-between">
                                            <div class="flex space-x-2 items-center text-sm pt-2">
                                                <div> {{$item->number_of_hours}} giờ</div>
                                                <div>·</div>
                                                <div> {{$item->lectures}} bài học</div>
                                            </div>
                                            <div class="text-lg font-semibold"> {{number_format($item->price)}} đ</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <a class="absolute bg-white uk-position-center-left -ml-3 flex items-center justify-center p-2 rounded-full shadow-md text-xl w-11 h-11 z-10 dark:bg-gray-800 dark:text-white"
               href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
            <a class="absolute bg-white uk-position-center-right -mr-3 flex items-center justify-center p-2 rounded-full shadow-md text-xl w-11 h-11 z-10 dark:bg-gray-800 dark:text-white"
               href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

        </div>

        <!--  slider courses -->
        <div class="sm:my-4 my-3 flex items-end justify-between pt-3">
            <h2 class="text-2xl font-semibold">Khoá học khác </h2>
            <a href="/course" class="text-blue-500 sm:block hidden">Xem tất cả</a>
        </div>

        <div class="mt-3">

            <h4 class="py-3 border-b font-semibold text-grey-700  mx-1 mb-4" hidden>
                <ion-icon name="star"></ion-icon>
                Featured today
            </h4>

            <!--  slider -->
            <div class="mt-3">

                <h4 class="py-3 border-b font-semibold text-grey-700  mx-1 mb-4" hidden>
                    <ion-icon name="star"></ion-icon>
                    Featured today
                </h4>

                <div class="relative" uk-slider="finite: true">

                    <div class="uk-slider-container px-1 py-3">

                        <ul
                                class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-2@s uk-grid-small uk-grid">
                            @foreach($newCourses as $item)

                                <li>

                                    <a href="/course/{{$item->slug}}" class="uk-link-reset">
                                        <div class="card uk-transition-toggle">
                                            <div class="card-media h-40">
                                                <div class="card-media-overly"></div>
                                                <img src="{{$item->thumbnail ?? 'https://vnpi-hcm.vn/wp-content/uploads/2018/01/no-image-800x600.png'}}"
                                                     alt="" class="">
                                                <span class="icon-play"></span>
                                            </div>
                                            <div class="card-body p-4">
                                                <div class="font-semibold line-clamp-2"> {{$item->title}} </div>
                                                <div class="flex space-x-2 items-center text-sm pt-3">
                                                    <div> {{$item->number_of_hours}} giờ</div>
                                                    <div> ·</div>
                                                    <div> {{$item->lectures}} bài học</div>
                                                </div>
                                                <div class="pt-1 flex items-center justify-between">
                                                    <div class="text-lg font-semibold"> {{number_format($item->price)}}
                                                        đ
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                </li>

                            @endforeach

                        </ul>

                        <a class="absolute bg-white top-1/4 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                           href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                        <a class="absolute bg-white top-1/4 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                           href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                    </div>
                </div>

            </div>

        </div>

        <!--  episcodes  -->
        <!-- this is user toggle media to remove unwanted class for small devices more check docs uikit on https://getuikit.com/docs/toggle. -->
        <div class="tube-card p-4 mt-3" uk-toggle="cls: tube-card p-4; mode: media; media: 640">

            <h4 class="py-3 px-5 border-b font-semibold text-grey-700 -mx-4 -mt-3 mb-4">Bài viết</h4>

            <div class="relative -mx-1" uk-slider="finite: true">

                <div class="uk-slider-container md:px-1 px-2 py-3">
                    <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-2 uk-grid-small uk-grid">

                        @foreach($posts as $item)
                            <li>
                                <a href="{{ route('bai-viet.chi_tiet', ['slug' => $item->slug]) }}">
                                    <div class="w-full md:h-40 h-28 overflow-hidden rounded-lg relative">
                                        <img src="{{$item->thumbnail ?? 'https://vnpi-hcm.vn/wp-content/uploads/2018/01/no-image-800x600.png'}}"
                                             alt=""
                                             class="w-full h-full absolute inset-0 object-cover">
                                        <span
                                                class="absolute bottom-2 right-2 px-2 py-1 text-xs font-semibold bg-black bg-opacity-50 text-white rounded">
                                                {{ date("d/m/Y", strtotime($item->created_at))}}</span>
                                    </div>
                                </a>
                                <div class="pt-3">
                                    <a href="/blog/{{$item->id}}"
                                       class="font-semibold line-clamp-2"> {{$item->title}} </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <a class="absolute bg-white top-16 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                       href="#" uk-slider-item="previous">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                    </a>
                    <a class="absolute bg-white top-16 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                       href="#" uk-slider-item="next">
                        <ion-icon name="chevron-forward-outline"></ion-icon>
                    </a>
                </div>
            </div>
        </div>

        <div class="sm:my-4 my-3 items-end justify-between pt-3">
            <h2 class="text-2xl font-semibold">Về chúng tôi</h2>
            <h3 class="mt-3 mb-3" style="font-weight: 500">Tầm nhìn </h3>
            <p>
                Chúng tôi luôn nỗ lực, phấn đấu trở thành trung tâm luyện thi tiếng anh hàng đầu Việt Nam.
                EL Center muốn tạo ra một thương hiệu là trung tâm tiên phong trong lĩnh vực dạy, luyện thi chứng chỉ
                tiếng anh trên toàn lãnh thỗ Việt Nam.
            </p>
            <h3 class="mt-3 mb-3" style="font-weight: 500">Sứ mệnh</h3>
            <p>
                Nâng cao kiến thức về tiếng anh cho thanh niên, học sinh, sinh viên, người đi làm là một trong những sứ mệnh cao cả của trung tâm El Center.
                Chúng tôi tạo sự khác biệt với đội ngũ giảng viên, giáo viên, hỗ trợ viên, tư vấn viên chuyên nghiệp nhất, trách nhiệm nhất, có đầy đủ kiến thức cơ bản
                và chuyên sâu nhất về dạy và đào tạo tiếng anh. Tạo dựng sự tin tưởng và chính sách nhất của khách hàng.
            </p>

            <p>
                Sau một thập kỷ hoạt động, Trung tâm tiếng anh El Center  đã phát triển thành hệ thống đào tạo tiếng anh uy tín, với hơn 30 cơ sở trải rộng khắp cả nước.
                Tại Anh ngữ EL Center mỗi học viên sẽ được trải nghiệm môi trường học tập tối ưu, linh hoạt đem lại chất lượng đào tạo tốt nhất.
            </p>
            <ul>
                <li>
                    Lộ trình học thiết kế riêng phù hợp
                    với quỹ thời gian,
                    mục tiêu đầu vào,
                    kỳ vọng đầu ra và
                    khả năng chi trả
                </li>
                <li>
                    Lịch học đa dạng:
                    sáng/chiều/tối
                    (buổi tối có 2 ca)
                    Hình thức học đa
                    dạng online và offline
                </li>
                <li>
                    Giáo viên hỗ trợ 24/7 theo kèm 1 : 1 từng học viên để tập trung nâng cao chất lượng
                </li>
            </ul>
        </div>
    </div>
@endsection
