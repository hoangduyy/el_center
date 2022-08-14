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
                            <a href="{{route('be.profile')}}">
                                <button type="button" class="btn btn-cyan btn-sm">Quay lại</button>
                            </a>
                        </div>

                        <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="card">
                                <form class="form-horizontal" id="form" action="{{route('be.profile.update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    @include('backend.layout.structures._error_validate')
                                    @include('backend.layout.structures._notification')

                                    <input type="hidden" name="teacher_id" value="{{$data->id}}">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email *</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" name="email" required disabled
                                                               placeholder="Nhập email" value="{{$data->email}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Họ tên</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="name" placeholder="Nhập tên" value="{{$data->name}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mật khẩu mới</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control" name="password"
                                                               placeholder="Nhập mật khẩu mới" value="">
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
