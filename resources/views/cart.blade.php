@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white rounded-md shadow-md">

                <h3 class="border-b font-semibold px-5 py-4 text-base text-gray-500">Giỏ hàng của bạn ({{ $count }})</h3>

                @if(session()->has('notification_success'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong style="color: red; margin-bottom: 15px">{{ session()->get('notification_success') }}</strong>
                    </div>
                @endif

                <div class="divide-y">
                    @php $total = 0; @endphp
                    @foreach($class as $item)
                        <div class="flex items-start space-x-6 relative py-7 px-6">
                            <div class="h-28 overflow-hidden relative rounded-md w-44">
                                <img src="{{ asset($item->thumbnail) }}" alt="" class="absolute w-full h-full inset-0 object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                @php $toDetailClass = !empty($item->course->slug) ? "/course/" .$item->course->slug. "/$item->id/detail" : "#" @endphp
                                <a href="{{$toDetailClass}}" class="md:text-lg font-semibold line-clamp-2 mb-2">{{ $item->title }}</a>
                                <a href="#" class="font-medium block text-sm">&nbsp;</a>
                                <div class="flex items-center mt-7 space-x-2 text-sm font-medium">
                                    <div> {{ !empty($item->course->title) ? $item->course->title : ''}}  </div>
                                </div>
                            </div>
                            <h5 class="font-semibold text-black text-xl">{{ !empty($item->course->price) ? number_format($item->course->price) : '' }} đ </h5>
                            @php $total += !empty($item->course->price) ? $item->course->price : 0; @endphp
                            <h5 class="absolute bottom-9 font-semibold right-4 text-blue text-blue-500">
                                <form action="{{ route('remove_item_cart', ['class_id' => $item->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Xóa đăng kí lớp học. Bạn có chắc không?')">Xóa</button>
                                </form>
                            </h5>
                        </div>
                    @endforeach
                </div>

                @php
                    $totalSale = $sale > 0 ? $total * $sale : 0;
                    $totalFinal = $sale > 0 ? $total - $total * $sale : $total;
                @endphp

                <div class="border-t mt-5 pt-6 space-y-6">
                    <div class="flex justify-between px-6">
                        <div class="flex-1 min-w-0">
                            <h1 class="text-lg font-medium">Khuyến mại: </h1>
                        </div>
                        <h5 class="font-semibold text-black text-xl"> - {{ number_format($totalSale) }} đ </h5>
                    </div>
                    <div class="flex justify-between px-6">
                        <div class="flex-1 min-w-0">
                            <h1 class="text-lg font-medium">Tổng: </h1>
                        </div>
                        <h5 class="font-semibold text-black text-xl"> {{ number_format($totalFinal) }} đ </h5>
                    </div>
                    <div class="px-6 pb-5">
                        <form action="{{ route('checkout') }}" method="post">
                            @csrf
                            <input type="hidden" name="sale" value="{{ $sale }}">
                            <input type="hidden" name="total" value="{{ $total }}">
                            <input type="hidden" name="total_final" value="{{ $totalFinal }}">
                            <button type="submit" style="width: 100%" onclick="return confirm('Thanh toán. Bạn có chắc không?')"
                                    class="bg-blue-600 block py-3 rounded-md text-white text-center text-base font-semibold hover:text-white hover:bg-blue-700">
                                Thanh toán
                            </button>
                        </form>
                        <div class="flex items-center justify-center mt-4 space-x-1.5">
                             <a href="{{ route('course') }}" class="text-blue-600 font-semibold text-center"> Tiếp tục mua khóa học</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
