@extends('backend.layout.main')

@push('styles')
    <link href="/backend/css/dashboard.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content-page">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Trang quản trị {{ bE()->name }}</h4>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="margin: 15px 15px 0 15px">
                        <div class="card-body">
                            @include('backend.layout.structures._notification')

                            <div class="card-body__head card-body__filter">
                                <h5 class="card-title bold">Thống kê</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-2 col-xlg-3">
                                    <div class="card card-hover">
                                        <div class="box bg-cyan text-center">
                                            <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                            <h6 class="text-white">Chi nhánh <br> ({{ \App\Models\Branch::count() }})</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-2 col-xlg-3">
                                    <div class="card card-hover">
                                        <div class="box bg-warning text-center">
                                            <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                            <h6 class="text-white">Phòng học <br> ({{ \App\Models\Room::count() }})</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-2 col-xlg-3">
                                    <div class="card card-hover">
                                        <div class="box bg-cyan text-center">
                                            <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                            <h6 class="text-white">Khóa học <br> ({{ \App\Models\Course::count() }}) </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-2 col-xlg-3">
                                    <div class="card card-hover">
                                        <div class="box bg-warning text-center">
                                            <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                            <h6 class="text-white">Lớp học <br> ({{\App\Models\ClassRoom::count()}})</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-2 col-xlg-3">
                                    <div class="card card-hover">
                                        <div class="box bg-cyan text-center">
                                            <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                            <h6 class="text-white">Giáo viên <br> ({{ \App\Models\Teacher::count() }})</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-2 col-xlg-3">
                                    <div class="card card-hover">
                                        <div class="box bg-warning text-center">
                                            <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                            <h6 class="text-white">Người dùng <br> ({{ \App\Models\User::count() }})</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-2 col-xlg-3">
                                    <div class="card card-hover">
                                        <div class="box bg-cyan text-center">
                                            <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                            <h6 class="text-white">Đơn hàng <br> ({{ \App\Models\Order::count() }})</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body__head card-body__filter">
                                <h5 class="card-title bold">Doanh thu</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-2 col-xlg-3">
                                    <div class="card card-hover">
                                        <div class="box bg-warning text-center">
                                            <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                            <h6 class="text-white">Doanh thu tuần <br> ({{ number_format($doanhThuTuan) }} đ) </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
