@extends('layouts.app')

@push('style')
    <link href="/client/assets/css/test.css" rel="stylesheet">
@endpush

@push('script')
    <script src="/client/assets/js/test.js"></script>
@endpush

@section('content')
<div class="container">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<input type="hidden" name="answer" value="{{ route('post.student.answer') }}">

<div class="max-w-3xl mt-lg-11 mx-auto lg:p-10 p-5 tube-card">


    <div class="text-center mt-4 mb-6 lg:mt-10">
        <h1 class="font-semibold md:text-3xl text-xl text-center uk-heading-line"><span>Kết quả bài test đầu vào</span></h1>
    </div>

    <div class="list-ques-ctn">
        @foreach($dethi as $key => $cauhoi)
            @php $user_da = $cauhoi->user_da @endphp
            @php $question_da = $cauhoi->question_da @endphp
            @php
                $cauhoi = \App\Models\Question::whereId($cauhoi->question_id)->first();
            @endphp

            @if (!empty($cauhoi))
                <div class="quiz-form__quiz tab-pane fade in" id="question_{{$cauhoi->id}}">
                    <p class="quiz-form__question">{{$key + 1}}: {{ $cauhoi->question }}</p>

                    <label class="quiz-form__ans">
                        <input type="radio" name="q1[{{$key}}]" data-question-id="{{$cauhoi->id}}" value="a" {{ $user_da == "a" ? "checked" : '' }}>
                        <span class="text text-wrong {{ $question_da == 'a' ? 'colorXanh' : '' }}">{{$cauhoi->da_a}}</span>
                    </label>

                    <label class="quiz-form__ans">
                        <input type="radio" name="q1[{{$key}}]" data-question-id="{{$cauhoi->id}}" value="b" {{ $user_da == "b" ? "checked" : '' }}>
                        <span class="text text-wrong {{ $question_da == 'b' ? 'colorXanh' : '' }}">{{$cauhoi->da_b}}</span>
                    </label>

                    <label class="quiz-form__ans">
                        <input type="radio" name="q1[{{$key}}]" data-question-id="{{$cauhoi->id}}" value="c" {{ $user_da == "c" ? "checked" : '' }}>
                        <span class="text text-wrong {{ $question_da == 'c' ? 'colorXanh' : '' }}">{{$cauhoi->da_c}}</span>
                    </label>

                    <label class="quiz-form__ans">
                        <input type="radio" name="q1[{{$key}}]" data-question-id="{{$cauhoi->id}}" value="d" {{ $user_da == "d" ? "checked" : '' }}>
                        <span class="text text-wrong {{ $question_da == 'd' ? 'colorXanh' : '' }}">{{$cauhoi->da_d}}</span>
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>
</div>
@endsection
