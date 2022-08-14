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
                            <a href="{{route('be.class.index')}}">
                                <button type="button" class="btn btn-cyan btn-sm">Quay lại</button>
                            </a>
                        </div>

                        <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="card">
                                <form class="form-horizontal" id="form" action="{{route('be.class.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    @include('backend.layout.structures._error_validate')
                                    @include('backend.layout.structures._notification')

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Tên *</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="title" required placeholder="Nhập tên" value="{{old('title')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Ảnh đại diện *</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" name="thumbnail" accept="image/*" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Ghi chú</label>
                                                    <div class="col-sm-8">
                                                        <textarea row="6" id="note" class="form-control" name="note">{{old('note')}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Số học viên *</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" name="qty" class="form-control" min="1" required value="{{ old('qty') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Ngày bắt đầu *</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="start_date" class="form-control" required value="{{ old('start_date') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Ngày kết thúc *</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="end_date" class="form-control" required value="{{ old('end_date') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Khóa học *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                            <select class="my-select2__select2 select2-wrapper" name="course_id" required>
                                                                <option selected readonly value="">--- Vui lòng chọn ---</option>
                                                                @foreach($course as $item)
                                                                    <option value = "{{ arrayGet($item, 'id') }}"
                                                                            {{ old('course_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                                        {{ arrayGet($item, 'title') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Phòng học *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                            <select class="my-select2__select2 select2-wrapper" name="room_id" required>
                                                                <option selected readonly value="">--- Vui lòng chọn ---</option>
                                                                @foreach($rooms as $item)
                                                                    <option value = "{{ arrayGet($item, 'id') }}"
                                                                            {{ old('room_id') == arrayGet($item, 'id') ? "selected" : '' }}>
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

@push('script')
    <script>
        if (selectorIsExits("#editor-quill")) {
            var quillValue = $('input[name=content]').val();
            var quill = new Quill('#editor-quill', {
                modules: {
                    toolbar: [
                        ['bold', 'italic'],
                        ['link', 'blockquote', 'code-block', 'image'],
                        [{ list: 'ordered' }, { list: 'bullet' }]
                    ]
                },
                placeholder: 'Nhập nội dung',
                theme: 'snow'
            });
            quill.root.innerHTML = quillValue;

            $("#form").submit(function() {
                let input = $('#editor-quill').parent().children('input[type="hidden"]');
                input.val(quill.root.innerHTML.trim());
                return true; // submit form
            });
        }
    </script>
@endpush
