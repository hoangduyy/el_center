@extends('backend.layout.main')

@section('content')
    <div class="content-page teacher-page">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Đơn đăng kí</h4>
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
                                <h5 class="card-title">Chi tiết đơn hàng #{{$id}}</h5>
                                <a href="{{route('be.order')}}">
                                    <button type="button" class="btn btn-cyan btn-sm">Quay lại</button>
                                </a>
                            </div>

                            <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <table class="table table-striped table-bordered dataTable" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Tên lớp</th>
                                            <th scope="col">Ảnh đại diện</th>
                                            <th scope="col">Giá tiền (vnđ)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($class as $key => $entity )
                                        <tr>
                                            <td width="50px">{{ $key + 1 }}</td>
                                            <td>{{ $entity->title }}</td>
                                            <td>
                                                <img src="{{ asset($entity->thumbnail) }}" width="60px" alt="">
                                            </td>
                                            <td>{{ !empty($entity->course->price) ? number_format($entity->course->price) : '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
