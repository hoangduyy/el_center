@extends('layouts.app')

@section('content')
<div class="container">

    <div class="text-2xl font-semibold"> Tin tức </div>

    <div class="lg:flex lg:space-x-4 lg:-mx-4 mt-6">

        <div class="lg:w-10/12">
            <div class="divide-y tube-card px-6 md:m-0 -mx-5">
                <div class="md:flex md:space-x-6 py-5">
                    <div class="flex-1 md:pt-0 pt-4">
                        <a href="{{ route('tin_tuc.chi_tiet', ['slug' => $item->slug]) }}" class="text-xl font-semibold line-clamp-2 leading-8">{{$item->name}}</a>
                        <p class="line-clamp-2"> {{ $item->description }} </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
