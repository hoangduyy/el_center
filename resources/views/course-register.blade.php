@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class="md:text-2xl text-xl leading-none text-gray-900 tracking-tight my-3"> Đăng ký học </h1>

        <nav class="cd-secondary-nav border-b md:m-0 -mx-4 nav-small">
            <ul>
                <li class="active"><a href="#" class="lg:px-2">Thông tin chung </a></li>
            </ul>
        </nav>

        <div class="grid lg:grid-cols-2 mt-12 gap-8">
            <div class="group-info">
                <h3 class="text-xl mb-3"> Thông tin </h3>

                @if (!fE())
                    <h5 style="color: red">Bạn phải đăng nhập để thực hiện chức năng này. <br>
                    <a href="/login">Login</a> ngay nếu bạn đã có tài khoản hoặc <a href="/register">đăng kí </a> tham gia thành viên.</h5>
                @endif

                @if(session()->has('notification_error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong style="color: red; margin-bottom: 15px">{{ session()->get('notification_error') }}</strong>
                    </div>
                @endif

                <div class="bg-white rounded-md lg:shadow-md shadow col-span-2 p-4">
                    <div>Tên lớp học: <span>{{$class->title}}</span></div>
                    <div>Mã lớp học: <span>#{{$class->id}}</span></div>
                    <div>Phòng học: <span>{{!empty($class->room->name) ? $class->room->name : ''}}</span></div>
                    <div>Sỉ số: <span>{{$class->qty}} học sinh</span></div>
                    <div>Ngày bắt đầu: <span>{{ date('d-m-Y', strtotime($class->start_date)) }}</span></div>
                    <div>Ngày kết thúc: <span>{{ date('d-m-Y', strtotime($class->end_date)) }}</span></div>
                    <div>Học phí: <strong class="bold text-danger">{{ number_format($data->price) }}</strong> (vnd)
                    </div>

                    <br>

                    {{--@if (fE())--}}
                        {{--<form action="" method="post">--}}
                            {{--@csrf--}}
                            {{--<button type="submit" onclick="return confirm('Đăng kí lớp học. Bạn có chắc không?')" class="button bg-blue-700">Đăng ký</button>--}}
                        {{--</form>--}}
                    {{--@endif--}}

                    @if (fE())
                        <form action="{{ route('add_cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="class_id" value="{{$class->id}}">
                            {{--<input type="hidden" name="total" value="{{$data->price}}">--}}
                            {{--<input type="hidden" name="fullName" value="{{fE()->name}}">--}}

                            {{--// @todo add phone --}}
                            {{--<input type="hidden" name="phone" value="0123456789">--}}
                            {{--<input type="hidden" name="email" value="{{ fE()->email }}">--}}
                            {{--<input type="hidden" name="user_id" value="{{ fE()->id }}">--}}

                            <button type="submit" onclick="return confirm('Đăng kí lớp học. Bạn có chắc không?')" class="button bg-blue-700">Đăng ký</button>
                        </form>
                    @endif

                    {{--@todo--}}
                    {{--<div>Lịch học Thứ: {{$class->schedule->days}}</div>--}}

                    {{--@todo add start_hour and end_hour--}}
                    {{--<div>Khung giờ: {{$class->schedule->start_hour}} - {{$class->schedule->end_hour}}</div>--}}
                </div>
            </div>
        </div>

    </div>
@endsection
