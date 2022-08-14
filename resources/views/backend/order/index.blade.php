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

                            <div class="card-body__head card-body__filter">
                                <h5 class="card-title bold">Bộ lọc</h5>
                            </div>

                            <!-- From search -->
                            <form method="GET" action="{{ route('be.order') }}" class="mb-5" id="form-search">
                                <div class="form-row">
                                    <div class="col-md-1">
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="phone" class="form-control" placeholder="SĐT" value="{{ request('phone') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
                                    </div>
                                </div>

                                <div class="card-body__head card-body__filter text-center">
                                    <button type="submit" class="btn btn-cyan btn-sm">Tìm kiếm</button>
                                </div>
                            </form>

                            <div class="card-body__head d-flex">
                                <h5 class="card-title">Danh sách</h5>
                            </div>

                            <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <table class="table table-striped table-bordered dataTable" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="50px">ID</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">SĐT</th>
                                            <th scope="col">Giá gốc (vnđ)</th>
                                            <th scope="col">Khuyến mại (%)</th>
                                            <th scope="col">Giá tiền (vnđ)</th>
                                            <th scope="col">Ngày đăng kí</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $key => $entity )
                                        <tr>
                                            <td>{{ $entity->id }}</td>
                                            <td>{{ $entity->fullName }}</td>
                                            <td>{{ $entity->email }}</td>
                                            <td>{{ $entity->phone }}</td>
                                            <td>{{ number_format($entity->total) }}</td>
                                            <td>- {{ $entity->sale }}</td>
                                            <td>{{ number_format($entity->total_final) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($entity->created_at)) }}</td>
                                            <td>{{ $entity->status == \App\Models\Order::STATUS_SUCCESS ? 'Thành công' : "Thất bại" }}</td>
                                            <td>
                                                <a href="{{ route('be.order_detail', ['id' => $entity->id]) }}">
                                                    <button type="button" class="btn btn-cyan btn-xs">Chi tiết</button>
                                                </a>
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
