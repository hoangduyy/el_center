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
                            <h5 class="card-title">Cập nhật</h5>
                            <a href="{{route('be.course.index')}}">
                                <button type="button" class="btn btn-cyan btn-sm">Quay lại</button>
                            </a>
                        </div>

                        <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="card">
                                <form class="form-horizontal" id="form" action="{{route('be.course.update', ['course' => $data->id])}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    @include('backend.layout.structures._error_validate')
                                    @include('backend.layout.structures._notification')

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Tên *</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="title" required placeholder="Nhập tên" value="{{$data->title}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Ảnh đại diện *</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" name="thumbnail" accept="image/*">
                                                        <img src="{{ asset($data->thumbnail) }}" alt="" width="100px" class="d-block">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mô tả *</label>
                                                    <div class="col-sm-8">
                                                        <textarea row="6" id="description" class="form-control" name="description" required>{{$data->description}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Số giờ *</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" name="number_of_hours" class="form-control" min="0" required value="{{ $data->number_of_hours }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Giá (VNĐ) *</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" name="price" class="form-control" min="0" required value="{{ $data->price }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Số bài học *</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" name="lectures" class="form-control" min="0" required value="{{ $data->lectures }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Ngày bắt đầu *</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="start_date" class="form-control" required value="{{ $data->start_date }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Trình độ *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                            <select class="my-select2__select2 select2-wrapper" name="level_id" required>
                                                                <option selected readonly value="">--- Vui lòng chọn ---</option>
                                                                @foreach($level as $item)
                                                                    <option value = "{{ arrayGet($item, 'id') }}"
                                                                            {{ $data->level_id == arrayGet($item, 'id') ? "selected" : '' }}>
                                                                        {{ arrayGet($item, 'name') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Nội dung</label>
                                                    <div class="col-sm-8">
                                                        <input name="content" type="hidden" value="{{ $data->content }}">
                                                        <div id="editor-quill"></div>
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
