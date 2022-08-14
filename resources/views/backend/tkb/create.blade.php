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
                        <div class="card-body__head d-flex">
                            <h5 class="card-title">Thêm mới</h5>
                            <a href="{{route('be.tkb.index')}}">
                                <button type="button" class="btn btn-cyan btn-sm">Quay lại</button>
                            </a>
                        </div>

                        <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <p>
                                <small class="text-danger">Bạn không thể sửa thông tin đã gửi đi. Vì vậy hãy chắc chắn rằng thông tin bạn xếp thời khóa biểu là chính xác.</small>
                            </p>

                            <div class="card">
                                <form class="form-horizontal" id="form" action="{{route('be.tkb.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    @include('backend.layout.structures._error_validate')
                                    @include('backend.layout.structures._notification')

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Chọn lớp *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                        <select class="my-select2__select2 select2-wrapper" name="class_id" required>
                                                            <option selected readonly value="">--- Vui lòng chọn ---</option>
                                                            @foreach($class as $item)
                                                                <option value = "{{ arrayGet($item, 'id') }}"
                                                                        {{ old('class_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                                    {{ arrayGet($item, 'title') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Chọn giáo viên *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                            <select class="my-select2__select2 select2-wrapper" name="teacher_id" required>
                                                                <option selected readonly value="">--- Vui lòng chọn ---</option>
                                                                @foreach($teacher as $item)
                                                                    <option value = "{{ arrayGet($item, 'id') }}"
                                                                            {{ old('teacher_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                                        {{ arrayGet($item, 'name') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Chọn phòng *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                            <select class="my-select2__select2 select2-wrapper" name="room_id" required>
                                                                <option selected readonly value="">--- Vui lòng chọn ---</option>
                                                                @foreach($room as $item)
                                                                    <option value = "{{ arrayGet($item, 'id') }}"
                                                                            {{ old('room_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                                        {{ arrayGet($item, 'name') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Khung giờ *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                            <select class="my-select2__select2 select2-wrapper" name="time_id" required>
                                                                <option selected readonly value="">--- Vui lòng chọn ---</option>
                                                                @foreach(getKhungGio() as $key => $item)
                                                                    <option value = "{{ $key }}"
                                                                            {{ old('time_id') == $key ? "selected" : '' }}>
                                                                        {{ $item }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Chọn ngày *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                            <select class="my-select2__select2 select2-wrapper" multiple name="day_id[]" required>
                                                                @foreach(getDayWeek() as $key => $item)
                                                                    <option value="{{$key}}"
                                                                            {{ in_array($key, old('day_id', [])) ? "selected" : '' }}>
                                                                        {{ $item }}
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
