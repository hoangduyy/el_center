@extends('layouts.app')

@section('content')
<div class="container">

    <div class="text-2xl font-semibold"> Tin tức </div>
    <nav class="cd-secondary-nav border-b md:m-0 nav-small">
        <ul>
            <li class="active"><a href="#" class="lg:px-2"> Mới </a></li>
        </ul>
    </nav>

    <div class="lg:flex lg:space-x-4 lg:-mx-4 mt-6">

        <div class="lg:w-10/12">
            <div class="divide-y tube-card px-6 md:m-0 -mx-5">
                @foreach ($data as $item)
                <div class="md:flex md:space-x-6 py-5">
                    <a href="blog-read.html">
                        <div class="md:w-56 w-full h-36 overflow-hidden rounded-lg relative shadow-sm">
                            <img src="{{$item->thumbnail ?? 'https://vnpi-hcm.vn/wp-content/uploads/2018/01/no-image-800x600.png'}}" alt="" class="w-full h-full absolute inset-0 object-cover">
                            <div class="absolute bg-blue-100 font-semibold px-2.5 py-1 rounded-full text-blue-500 text-xs top-2.5 left-2.5">
                                JavaScript
                            </div>
                        </div>
                    </a>
                    <div class="flex-1 md:pt-0 pt-4">

                        <a href="blog-read.html" class="text-xl font-semibold line-clamp-2 leading-8">{{$item->title}}</a>
                        <p class="line-clamp-2"> {{strlen($item->description) > 200 ? substr($item->description,200) . '...' : $item->description}}   </p>

                        <div class="flex items-center pt-2 text-sm">
                            <div class="flex items-center">
                                <ion-icon name="bookmark-outline" class="text-xl mr-2"></ion-icon>
                            </div>
                        </div>

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
