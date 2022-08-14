@extends('teacher.layout.main')

@push('vendor_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
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
                        @include('backend.layout.structures._notification')

                        <div class="card-body__head d-flex">
                            <h5 class="card-title">Thời khóa biểu giáo viên</h5>
                        </div>

                        <div id="zero_config_wrapper" class="dataTables_wrapper dt-bootstrap4">

                            <table class="table table-striped table-bordered dataTable" role="grid">
                                <thead>
                                <tr>
                                    <th scope="col" width="50px">ID</th>
                                    <th scope="col">Tên lớp</th>
                                    <th scope="col">Ngày bắt đầu</th>
                                    <th scope="col">Ngày kết thúc</th>
                                    <th scope="col">Phòng học</th>
                                    <th scope="col">Giờ học</th>
                                    <th scope="col">Ngày học</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $entity )
                                    <tr>
                                        <td>{{ $entity->id }}</td>
                                        <td>{{ !empty($entity->class->title) ? $entity->class->title : '' }}</td>
                                        <td>{{ !empty($entity->class->start_date) ? date('d-m-Y', strtotime($entity->class->start_date)) : '' }}</td>
                                        <td>{{ !empty($entity->class->end_date) ? date('d-m-Y', strtotime($entity->class->end_date)) : '' }}</td>
                                        <td>{{ !empty($entity->room->name) ? $entity->room->name : '' }}</td>
                                        <td>{{ arrayGet(getKhungGio(), $entity->time_id) }}</td>
                                        <td>
                                            @foreach($entity->details()->pluck('day_id')->toArray() as $day)
                                                - {{ arrayGet(getDayWeek(), $day) }} <br>
                                            @endforeach
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
