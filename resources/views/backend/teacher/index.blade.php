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
                            <form method="GET" action="{{ route('be.teacher.index') }}" class="mb-5" id="form-search">
                                <div class="form-row">
                                    <div class="col-md-1">
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="phone" class="form-control" placeholder="SĐT" value="{{ request('phone') }}">
                                    </div>
                                </div>

                                <div class="card-body__head card-body__filter text-center">
                                    <button type="submit" class="btn btn-cyan btn-sm">Tìm kiếm</button>
                                </div>
                            </form>

                            <div class="card-body__head d-flex">
                                <h5 class="card-title">Danh sách</h5>
                                @if (isAdmin())
                                    <a href="{{route('be.teacher.create')}}">
                                        <button type="button" class="btn btn-cyan btn-sm">Thêm mới</button>
                                    </a>
                                @endif
                            </div>

                            <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <table class="table table-striped table-bordered dataTable" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="50px">ID</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">SĐT</th>
                                            <th scope="col">Giới tính</th>
                                            <th scope="col">Ngày sinh</th>
                                            <th scope="col">Học vị</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $key => $entity )
                                        <tr>
                                            <td>{{ $entity->id }}</td>
                                            <td>{{ $entity->name }}</td>
                                            <td>{{ $entity->email }}</td>
                                            <td>{{ $entity->phone }}</td>
                                            <td>{{ $entity->gender == \App\Models\Teacher::GENDER_BOY ? 'Nam' : 'Nữ' }}</td>
                                            <td>{{ $entity->birthday }}</td>
                                            <td>{{ !empty($entity->degree->name) ? $entity->degree->name : ''}}</td>
                                            <td>
                                                <div class="comment-footer d-flex">
                                                    <a href="{{ route('be.teacher.edit', ['teacher' => $entity->id]) }}">
                                                        <button type="button" class="btn btn-cyan btn-xs">Sửa</button>
                                                    </a>
                                                    <form action="{{ route('be.teacher.destroy', ['teacher' => $entity->id]) }}" method="post">
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
