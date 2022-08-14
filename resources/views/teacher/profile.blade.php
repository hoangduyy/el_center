@extends('teacher.layout.main')

@section('content')
<div class="content-page teacher-page">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title"></h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('backend.layout.structures._notification')

                        <div class="card-body__head d-flex">
                            <h5 class="card-title">Hồ sơ giáo viên</h5>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Chi tiết</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td>{{$data->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{$data->email}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">SĐT</th>
                                    <td>{{$data->phone}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Ngày sinh</th>
                                    <td>{{ date('d-m-Y', strtotime($data->birthday)) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Giới tính</th>
                                    <td>{{ $data->gender == \App\Models\Teacher::GENDER_BOY ? 'Nam' : 'Nữ' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Chứng chỉ</th>
                                    <td>
                                        @foreach($certificate as $item)
                                            <button class="btn btn-xs btn-primary mr-2">{{ $item }}</button>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Học vị</th>
                                    <td>{{ !empty($data->degree->name) ? $data->degree->name : ''}}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="comment-footer d-flex">
                            <a href="{{ route('t.profile.edit') }}">
                                <button type="button" class="btn btn-cyan btn-xs">Cập nhật</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
