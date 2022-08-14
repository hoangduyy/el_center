@extends('backend.layout.main')

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
                            <h5 class="card-title">Hồ sơ {{ $data->name }}</h5>
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
                                    <th scope="row">Quyền</th>
                                    <td>{{$data->role}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Ngày tạo</th>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($data->created_at)) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="comment-footer d-flex">
                            <a href="{{ route('be.profile.edit') }}">
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
