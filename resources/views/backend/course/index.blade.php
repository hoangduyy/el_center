@extends('backend.layout.main')

@section('content')
    <div class="content-page teacher-page">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Khóa học</h4>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @include('backend.layout.structures._notification')

                            <div class="card-body__head card-body__filter">
                                <h5 class="card-title bold">Bộ lọc</h5>
                            </div>

                            <!-- From search -->
                            <form method="GET" action="{{ route('be.course.index') }}" class="mb-5" id="form-search">
                                <div class="form-row">
                                    <div class="col-md-1">
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="title" class="form-control" placeholder="Tên" value="{{ request('title') }}">
                                    </div>
                                </div>

                                <div class="card-body__head card-body__filter text-center">
                                    <button type="submit" class="btn btn-cyan btn-sm">Tìm kiếm</button>
                                </div>
                            </form>

                            <div class="card-body__head d-flex">
                                <h5 class="card-title">Danh sách</h5>
                                <a href="{{route('be.course.create')}}">
                                    <button type="button" class="btn btn-cyan btn-sm">Thêm mới</button>
                                </a>
                            </div>

                            <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <table class="table table-striped table-bordered dataTable" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="50px">ID</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Slug</th>
                                            <th scope="col">Ảnh đại diện</th>
                                            <th scope="col">Trình độ</th>
                                            <th scope="col">Số giờ học</th>
                                            <th scope="col">Học phí (VNĐ)</th>
                                            <th scope="col">Ngày bắt đầu</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $key => $entity )
                                        <tr>
                                            <td>{{ $entity->id }}</td>
                                            <td>{{ $entity->title }}</td>
                                            <td>{{ $entity->slug }}</td>
                                            <td>
                                                <img src="{{ asset($entity->thumbnail) }}" width="60px" alt="">
                                            </td>
                                            <td>{{ !empty($entity->level->name) ? $entity->level->name : ''}}</td>
                                            <td>{{ $entity->number_of_hours }}</td>
                                            <td>{{ number_format($entity->price) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($entity->start_date)) }}</td>
                                            <td>
                                                <div class="comment-footer d-flex">
                                                    <a href="{{ route('be.course.edit', ['course' => $entity->id]) }}">
                                                        <button type="button" class="btn btn-cyan btn-xs">Sửa</button>
                                                    </a>
                                                    <form action="{{ route('be.course.destroy', ['course' => $entity->id]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-danger btn btn-xs rounded"
                                                           onclick="return confirm('Xoá. Bạn có chắc không?')"
                                                        >
                                                            Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                {{ $list->appends(request()->all())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
