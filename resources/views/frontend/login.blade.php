@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="md:text-2xl text-xl leading-none text-gray-900 tracking-tight my-3"> Đăng nhập với ELCenter </h1>
    <a href="{{ route('forgot_password') }}">Quên mật khẩu</a>

    <div class="grid lg:grid-cols-3 mt-12 gap-8 ">
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
            @if(session()->has('error'))
                <div class="grid grid-cols-2 gap-3 lg:p-6 p-4">
                    <div class="alert alert-danger" style="color: red">
                        {{ session()->get('error') }}
                    </div>
                </div>
            @endif
            <form method="POST" action="{{ route('post.login') }}">
                @csrf
                <div class="grid grid-cols-2 gap-3 lg:p-6 p-4">
                    <div class="col-span-2">
                        <label for="email">Email (*)</label>
                        <input name="email" type="text" placeholder="" id="email" class="shadow-none with-border" value="{{old('email')}}">
                    </div>
                    <div class="col-span-2">
                        <label for="email">Mật khẩu (*)</label>
                        <input name="password" type="password" placeholder="" id="password" class="shadow-none with-border">
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
