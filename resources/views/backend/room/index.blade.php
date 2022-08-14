@extends('backend.layout.main')

@section('content')
    <div class="content-page teacher-page">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Phòng học</h4>
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
                            <form method="GET" action="{{ route('be.room.index') }}" class="mb-5" id="form-search">
                                <div class="form-row">
                                    <div class="col-md-1">
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
                                    </div>
                                </div>

                                <div class="card-body__head card-body__filter text-center">
                                    <button type="submit" class="btn btn-cyan btn-sm">Tìm kiếm</button>
                                </div>
                            </form>

                            <div class="card-body__head d-flex">
                                <h5 class="card-title">Danh sách</h5>
                                <a href="{{route('be.room.create')}}">
                                    <button type="button" class="btn btn-cyan btn-sm">Thêm mới</button>
                                </a>
                            </div>

                            <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <table class="table table-striped table-bordered dataTable" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="50px">ID</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Mô tả</th>
                                            <th scope="col">Chi nhánh</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $key => $entity )
                                        <tr>
                                            <td>{{ $entity->id }}</td>
                                            <td>{{ $entity->name }}</td>
                                            <td>{{ $entity->description }}</td>
                                            <td>{{ !empty($entity->branch->name) ? $entity->branch->name : '' }}</td>
                                            <td>
                                                <div class="comment-footer d-flex">
                                                    <a href="{{ route('be.room.edit', ['room' => $entity->id]) }}">
                                                        <button type="button" class="btn btn-cyan btn-xs">Sửa</button>
                                                    </a>
                                                    <form action="{{ route('be.room.destroy', ['room' => $entity->id]) }}" method="post">
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
