@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="text-2xl font-semibold">Bài viết</div>

        <div class="lg:flex lg:space-x-4 lg:-mx-4 mt-6">

            <div class="lg:w-10/12">
                <div class="divide-y tube-card px-6 md:m-0 -mx-5">
                    @foreach ($data as $item)
                        <div class="md:flex md:space-x-6 py-5">
                            <a href="{{ route('bai-viet.chi_tiet', ['slug' => $item->slug]) }}">
                                <div class="md:w-56 w-full h-36 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="{{asset($item->thumbnail)}}" alt="" class="w-full h-full absolute inset-0 object-cover">
                                </div>
                            </a>
                            <div class="flex-1 md:pt-0 pt-4">

                                <a href="{{ route('bai-viet.chi_tiet', ['slug' => $item->slug]) }}" class="text-xl font-semibold line-clamp-2 leading-8">{{$item->title}}</a>
                                <p class="line-clamp-2"> {{strlen($item->description) > 200 ? substr($item->description,200) . '...' : $item->description}}   </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end mt-5">
                    {{$data->links('pagination.default')}}
                </div>
            </div>

        </div>
    </div>
@endsection
