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
                            <a href="{{route('be.teacher.index')}}">
                                <button type="button" class="btn btn-cyan btn-sm">Quay lại</button>
                            </a>
                        </div>

                        <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="card">
                                <form class="form-horizontal" id="form" action="{{route('be.teacher.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    @include('backend.layout.structures._error_validate')
                                    @include('backend.layout.structures._notification')

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Họ tên *</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="name" required placeholder="Nhập tên" value="{{old('name')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email *</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" name="email" required placeholder="Nhập email" value="{{old('email')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">SĐT *</label>
                                                    <div class="col-sm-8">
                                                        <input type="tel" class="form-control" name="phone" required placeholder="Nhập sđt" value="{{old('phone')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Ngày sinh *</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control" name="birthday" required value="{{old('birthday')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Học vị *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                        <select class="my-select2__select2 select2-wrapper" name="degree_id" required>
                                                            <option selected readonly value="">--- Vui lòng chọn ---</option>
                                                            @foreach($degree as $item)
                                                                <option value = "{{ arrayGet($item, 'id') }}"
                                                                        {{ old('degree_id') == arrayGet($item, 'id') ? "selected" : '' }}>
                                                                    {{ arrayGet($item, 'name') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Chứng chỉ *</label>
                                                    <div class="col-sm-8">
                                                        <div class="my-select2">
                                                            <select class="my-select2__select2 select2-wrapper" multiple name="certificate_id[]" required>
                                                                @foreach($certificate as $item)
                                                                    <option value = "{{ arrayGet($item, 'id') }}"
                                                                            {{ in_array(arrayGet($item, 'id'), old('certificate_id', [])) ? "selected" : '' }}>
                                                                        {{ arrayGet($item, 'name') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Giới tính</label>
                                                    <div class="col-sm-8">
                                                        <fieldset id="group2" style="position: relative; top: 8px">
                                                            <input type="radio" value="{{\App\Models\Teacher::GENDER_GIRL}}" name="gender"
                                                                    {{ old('gender', \App\Models\Teacher::GENDER_GIRL) ==  \App\Models\Teacher::GENDER_GIRL ? 'checked' : ''}}>
                                                            Nữ &nbsp;&nbsp;&nbsp;
                                                            <input type="radio" value="{{ \App\Models\Teacher::GENDER_BOY }}" name="gender"
                                                                    {{ old('gender', \App\Models\Teacher::GENDER_GIRL) ==  \App\Models\Teacher::GENDER_BOY ? 'checked' : ''}}>
                                                            Nam
                                                        </fieldset>
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
