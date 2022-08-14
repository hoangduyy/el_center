@extends('layouts.app')

@section('content')
    <style>
        th, td {
            min-width: 100px;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
<div class="container">

    <h1 class="md:text-2xl text-xl leading-none text-gray-900 tracking-tight my-3">Thông tin cá nhân</h1>
    <a href="{{ route('edit.profile') }}">Cập nhật</a>

    @if(session()->has('notification_success'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong style="color: red; margin-bottom: 15px">{{ session()->get('notification_success') }}</strong>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 mt-12 gap-8">
        <div class="bg-white rounded-md lg:shadow-md shadow col-span-2">
            <p class="mb-4"> Tên: {{ $user->name }}</p>
            <p class="mb-4"> Email: {{ $user->email }}</p>
            <p class="mb-4"> Kết quả test: {{$kq}}/{{getConfig('number_question')}} </p>
            <p class="mb-4"> Điểm test: {{$diem}} </p>
            @if ($user->status_test == \App\Models\User::STATUS_TESTED)
                Khóa học được gợi ý dựa vào kết quả test. <a href="{{ route('course.suggest') }}">Click</a>
            @endif
        </div>
    </div>

    <h1 class="md:text-2xl text-xl leading-none text-gray-900 tracking-tight my-3">Thông tin đơn hàng</h1>
    <div style="overflow-x:auto;">
        <table style="width: 100%" id="customers">
            <tr>
                <th width="50px">STT</th>
                <th width="50px">Mã đơn</th>
                <th>Ngày đăng kí</th>
                <th>Giá gốc</th>
                <th>Khuyến mại (%)</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
            @foreach($order as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>#{{ $item->id }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                    <td>{{ number_format($item->total) }}</td>
                    <td>- {{ $item->sale }}</td>
                    <td>{{ number_format($item->total_final) }}</td>
                    <td>{{ $item->status == \App\Models\Order::STATUS_SUCCESS ? 'Thành công' : "Thất bại" }}</td>
                    <td><a href="{{ route('order.show', ['id' => $item->id]) }}">Chi tiết</a></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
