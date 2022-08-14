@extends('backend.layout.main')

@push('script')
    <script src="{{ asset('backend/js/pages/product.js') }}"></script>
@endpush

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
                        <div class="card-body__head d-flex">
                            <h5 class="card-title">Thêm mới</h5>
                            <a href="{{route('be.room.index')}}">
                                <button type="button" class="btn btn-cyan btn-sm">Quay lại</button>
                            </a>
                        </div>

                        <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="card">
                                <form class="form-horizontal" action="{{route('be.room.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    @include('backend.layout.structures._error_validate')
                                    @include('backend.layout.structures._notification')

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Tên *</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="name" value="{{old('name')}}" required placeholder="Nhập tên phòng học">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mô tả *</label>
                                                    <div class="col-sm-8">
                                                        <textarea row="6" class="form-control" name="description" required>{{ old('description') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Chi nhánh *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                            <select class="my-select2__select2 select2-wrapper" name="branch_id" required>
                                                                <option selected readonly value="">--- Vui lòng chọn ---</option>
                                                                @foreach($branch as $item)
                                                                    <option value = "{{ arrayGet($item, 'id') }}"
                                                                            {{ old('branch_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                                        {{ arrayGet($item, 'name') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-top">
                                        <div class="card-body">
                                            <button type="submit" class="btn btn-success">Gửi đi</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
