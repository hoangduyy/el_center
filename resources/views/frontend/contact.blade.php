@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="md:text-2xl text-xl leading-none text-gray-900 tracking-tight my-3"> Liên hệ với ELCenter </h1>

    <div class="grid lg:grid-cols-3 mt-12 gap-8">
        <div>
            <p> Bạn đang gặp khó khăn cần được hỗ trợ hay cần đóng góp ý kiến cho bộ phận chăm sóc khách hàng? Hãy liên hệ với ELCenter qua bộ phận chăm sóc khách hàng. Chúng tôi sẽ giải quyết vấn đề của bạn nhanh nhất có thể! </p>
        </div>


        <div class="bg-white rounded-md lg:shadow-md shadow col-span-2">
            @if ($errors->any())
            <div class="grid grid-cols-2 gap-3 lg:p-6 p-4">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            @if(session()->has('success'))
            <div class="grid grid-cols-2 gap-3 lg:p-6 p-4">
                <div class="alert alert-success" style="color: green">
                    {{ session()->get('success') }}
                </div>
            </div>
            @endif
            <form method="POST" action="/contact">
                @csrf
                <div class="grid grid-cols-2 gap-3 lg:p-6 p-4">
                    <div class="col-span-2">
                        <label for="fullName"> Họ tên</label>
                        <input name="fullName" type="text" placeholder="" id="fullName" class="shadow-none with-border">
                    </div>
                    <div class="col-span-2">
                        <label for="email"> Email</label>
                        <input name="email" type="text" placeholder="" id="email" class="shadow-none with-border">
                    </div>
                    <div class="col-span-2">
                        <label for="subject"> Chủ đề</label>
                        <input name="subject" type="text" placeholder="" id="subject" class="shadow-none with-border">
                    </div>
                    <div class="col-span-2">
                        <label for="message">Nội dung</label>
                        <textarea id="about" name="message" rows="3" class="with-border"></textarea>
                    </div>
                </div>

                <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                    <button type="submit" class="button bg-blue-700"> Gửi </button>
                </div>
            </form>
        </div>
        <div>
        </div>
    </div>
    @endsection