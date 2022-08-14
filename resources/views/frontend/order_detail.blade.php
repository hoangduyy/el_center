@extends('layouts.app')

@section('content')
    <style>
        th, td {
            min-width: 100px;
        }

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
    <h1 class="md:text-2xl text-xl leading-none text-gray-900 tracking-tight my-3">Thông tin chi tiết đơn hàng #{{$id}}</h1>
    <a href="{{ route('get.profile') }}">Quay lại</a>
    <div style="overflow-x:auto; margin-top: 15px">
        <table id="customers">
            <tr>
                <th width="50px">STT</th>
                <th width="50px">Tên lớp</th>
                <th>Ảnh đại diện</th>
                <th>Giá</th>
            </tr>
            @foreach($class as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{$item->title}}</td>
                    <td>
                        <img src="{{ asset($item->thumbnail) }}" width="60px" alt="">
                    </td>
                    <td>{{ !empty($item->course->price) ? number_format($item->course->price) : '' }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
