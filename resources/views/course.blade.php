@extends('layouts.app')

@section('content')
    <style>
        .wrapper-course {
            display: flex;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
            list-style: none;
            position: unset;
        }

        .line-clamp-2 {
            word-wrap: break-word;
            white-space: normal;
            overflow: hidden;
            display: -webkit-box;
            text-overflow: ellipsis;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            height: 44px;
        }
    </style>
    <div class="container">

        <div class="text-2xl font-semibold mb-6">Danh sách khóa học</div>

        @if(count($data) > 0)
        <ul class="wrapper-course">
            <div class="row">
                @foreach ($data as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <li class="mb-6">
                            <a href="/course/{{$item->slug}}" class="uk-link-reset">
                                <div class="card uk-transition-toggle">
                                    <div class="card-media h-40">
                                        <div class="card-media-overly"></div>
                                        <img src="{{$item->thumbnail ?? 'https://vnpi-hcm.vn/wp-content/uploads/2018/01/no-image-800x600.png'}}" alt="" class="">
                                        <span class="icon-play"></span>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="font-semibold line-clamp-2">{{$item->title}}</div>
                                        <div class="flex space-x-2 items-center text-sm pt-3">
                                            <div> {{$item->number_of_hours}} giờ </div>
                                            <div> · </div>
                                            <div> {{$item->lectures}} bài học </div>
                                        </div>
                                        <div class="pt-1 flex items-center justify-between">
                                            <div class="text-lg font-semibold"> {{number_format($item->price)}} đ </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </div>
                @endforeach
            </div>
        </ul>
        @else
            <div class="alert alert-warning">Không có kết quả tìm kiếm</div>
        @endif
    </div>
@endsection
