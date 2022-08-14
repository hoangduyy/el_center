@extends('backend.layout.main')

@section('content')
    <div class="content-page teacher-page">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Giáo viên</h4>
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
                            <form method="GET" action="{{ route('be.tkb.index') }}" class="mb-5" id="form-search">
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="my-select2">
                                            <select class="my-select2__select2 select2-wrapper" name="class_id">
                                                <option selected readonly value="">--- Chọn lớp ---</option>
                                                @foreach($class as $item)
                                                    <option value="{{ arrayGet($item, 'id') }}"
                                                            {{ request('class_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                        {{ arrayGet($item, 'title') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="my-select2">
                                            <select class="my-select2__select2 select2-wrapper" name="teacher_id">
                                                <option selected readonly value="">--- Chọn GV ---</option>
                                                @foreach($teacher as $item)
                                                    <option value="{{ arrayGet($item, 'id') }}"
                                                            {{ request('teacher_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                        {{ arrayGet($item, 'name') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="my-select2">
                                            <select class="my-select2__select2 select2-wrapper" name="room_id">
                                                <option selected readonly value="">--- Chọn phòng ---</option>
                                                @foreach($room as $item)
                                                    <option value="{{ arrayGet($item, 'id') }}"
                                                            {{ request('room_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                        {{ arrayGet($item, 'name') }}
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
                                {{--@if (isAdmin())--}}
                                    <a href="{{route('be.tkb.create')}}">
                                        <button type="button" class="btn btn-cyan btn-sm">Thêm mới</button>
                                    </a>
                                {{--@endif--}}
                            </div>

                            <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <table class="table table-striped table-bordered dataTable" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="50px">ID</th>
                                            <th scope="col">Ngày bắt đầu</th>
                                            <th scope="col">Ngày kết thúc</th>
                                            <th scope="col">Tên lớp</th>
                                            <th scope="col">GV phụ trách</th>
                                            <th scope="col">Phòng học</th>
                                            <th scope="col">Giờ học</th>
                                            <th scope="col">Ngày học</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $key => $entity )
                                        <tr>
                                            <td>{{ $entity->id }}</td>
                                            <td>{{ !empty($entity->class->start_date) ? date('d-m-Y', strtotime($entity->class->start_date)) : '' }}</td>
                                            <td>{{ !empty($entity->class->end_date) ? date('d-m-Y', strtotime($entity->class->end_date)) : '' }}</td>
                                            <td>{{ !empty($entity->class->title) ? $entity->class->title : '' }}</td>
                                            <td>{{ !empty($entity->teacher->name) ? $entity->teacher->name : '' }}</td>
                                            <td>{{ !empty($entity->room->name) ? $entity->room->name : '' }}</td>
                                            <td>{{ arrayGet(getKhungGio(), $entity->time_id) }}</td>
                                            <td>
                                                @foreach($entity->details()->pluck('day_id')->toArray() as $day)
                                                    - {{ arrayGet(getDayWeek(), $day) }} <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="comment-footer">
                                                    <form action="{{ route('be.tkb.destroy', ['tkb' => $entity->id]) }}" method="post">
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
