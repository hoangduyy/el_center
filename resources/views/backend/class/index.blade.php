@extends('backend.layout.main')

@section('content')
    <div class="content-page teacher-page">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Lớp học</h4>
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
                            <form method="GET" action="{{ route('be.class.index') }}" class="mb-5" id="form-search">
                                <div class="form-row">
                                    <div class="col-md-1">
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="title" class="form-control" placeholder="Tên" value="{{ request('title') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="my-select2">
                                            <select class="my-select2__select2 select2-wrapper" name="course_id">
                                                <option selected readonly value="">--- Khóa học ---</option>
                                                @foreach($course as $item)
                                                    <option value="{{ arrayGet($item, 'id') }}"
                                                            {{ request('course_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                        {{ arrayGet($item, 'title') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body__head card-body__filter text-center">
                                    <button type="submit" class="btn btn-cyan btn-sm">Tìm kiếm</button>
                                </div>
                            </form>

                            <div class="card-body__head d-flex">
                                <h5 class="card-title">Danh sách</h5>
                                <a href="{{route('be.class.create')}}">
                                    <button type="button" class="btn btn-cyan btn-sm">Thêm mới</button>
                                </a>
                            </div>

                            <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <table class="table table-striped table-bordered dataTable" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="50px">ID</th>
                                            <th scope="col">Tên lớp</th>
                                            <th scope="col">Slug</th>
                                            <th scope="col">Ảnh đại diện</th>
                                            <th scope="col">Số học viên</th>
                                            <th scope="col">Khóa học</th>
                                            <th scope="col">Phòng học</th>
                                            <th scope="col">Ngày bắt đầu</th>
                                            <th scope="col">Ngày kết thúc</th>
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
                                            <td>{{ $entity->qty }}</td>
                                            <td>{{ !empty($entity->course->title) ? $entity->course->title : ''}}</td>
                                            <td>{{ !empty($entity->room->name) ? $entity->room->name : ''}}</td>
                                            <td>{{ date('d-m-Y', strtotime($entity->start_date)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($entity->end_date)) }}</td>
                                            <td>
                                                <div class="comment-footer d-flex">
                                                    <a href="{{ route('be.class.edit', ['class' => $entity->id]) }}">
                                                        <button type="button" class="btn btn-cyan btn-xs">Sửa</button>
                                                    </a>
                                                    <form action="{{ route('be.class.destroy', ['class' => $entity->id]) }}" method="post">
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
