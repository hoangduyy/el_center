@extends('layouts.app')

@section('content')
    <style>
        [class^=col] {
            display: flex;
            flex-direction: column;
        }

        [class^=col] div {
            flex-grow: 1
        }
    </style>


    <div class="container">
        <div class="mb-2">
            <div class="text-xl font-semibold">DANH SÁCH LỚP HỌC</div>
            <div class="text-sm mt-2 mb-3">Các lớp học có thể đăng kí</div>
        </div>
        <div class="row">
            @foreach($data->classes as $item)
                <div class="col-x col-sm-6 col-md-6 col-lg-4">
                    <a href="/course/{{$data->slug}}/{{$item->id}}/register" class="uk-link-reset">
                        <div class="card uk-transition-toggle">
                            <div class="card-media h-40">
                                <div class="card-media-overly"></div>
                                <img src="{{asset($item->thumbnail) ?? 'https://vnpi-hcm.vn/wp-content/uploads/2018/01/no-image-800x600.png'}}"
                                     alt="" class="">
                                <span class="icon-play"></span>
                            </div>
                            <div class="card-body p-4">
                                <div class="font-semibold line-clamp-2">
                                    <a href="/course/{{$data->slug}}/{{$item->id}}/register">{{$item->title}}</a>
                                </div>
                                <div class="flex space-x-2 items-center text-sm pt-3">
                                </div>
                                <div class="pt-1">
                                    <div>
                                        GV: {{ !empty($item->schedule->teacher->name) ? $item->schedule->teacher->name : "Đang xếp TKB" }}</div>
                                    <div>
                                        Phòng: {{ !empty($item->schedule->room->name) ? $item->schedule->room->name : "Đang xếp TKB" }}</div>

                                    <div>Lịch học:

                                        @if (!empty($item->schedule->details))
                                            @foreach($item->schedule->details()->pluck('day_id')->toArray() as $day)
                                                {{ arrayGet(getDayWeek(), $day) }} &nbsp;
                                            @endforeach
                                        @else
                                            <span>Đang xếp TKB</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            @endforeach
        </div>
        </ul>
    </div>
@endsection
