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

    <input type="hidden" value="{{ feGuard()->user()->time_test_start }}" name="start_time_exam" id="start_time_exam">
    <input type="hidden" value="{{ getConfig('time_test') }}" name="time_test" id="time_test">

    <div class="text-center mt-4 mb-6 lg:mt-10">
        <h1 class="font-semibold md:text-3xl text-xl text-center uk-heading-line"><span>Bài test đầu vào</span></h1>
    </div>
    <article class="space-y-2 uk-article">
        <div id="time-ctn" class="timer-ctn">
            <div id="clockdiv"></div>
            <form action="{{route('post.student.test.submit')}}" method="post" id="formNopbai" onsubmit="return confirm('Nộp bài, bạn có chắc không?');">
                @csrf
                <button type="submit" class="btn btn-green btn-submit" id="nopbai1">Nộp bài</button>
            </form>
        </div>
    </article>
    <article class="space-y-2 uk-article mb-3">
        <div>
            Bài thi gồm có {{ getConfig('number_question') }} câu, được chia làm {{ getConfig('number_question') / getConfig('number_question_on_page') }} trang.
            Mỗi trang gồm có {{ getConfig('number_question_on_page') }} câu hỏi.</div>
    </article>

    <div class="answer-ctn">
        <div class="asnswer-list">
            <ul class="list nav">
                <li class="numberCircle undone {{ $page == 1 ? "nenxanh" : '' }}">
                    <a data-toggle="tab" href="/test" id="link_page_1" class="">Trang 1</a>
                </li>

                <li class="numberCircle undone {{ $page == 2 ? "nenxanh" : '' }}">
                    <a data-toggle="tab" href="/test?page=2" id="link_page_2">Trang 2</a>
                </li>

                <li class="numberCircle undone {{ $page == 3 ? "nenxanh" : '' }}">
                    <a data-toggle="tab" href="/test?page=3" id="link_page_3" class="">Trang 3</a>
                </li>

                <li class="numberCircle undone {{ $page == 4 ? "nenxanh" : '' }}">
                    <a data-toggle="tab" href="/test?page=4" id="link_page_4">Trang 4</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="list-ques-ctn">
        @foreach($dethi as $key => $cauhoi)
            @php
                $tmp = $key + 1;
                $testResult = \App\Models\TestResult::whereUserId(feGuard()->user()->id)->whereQuestionId($cauhoi->id)->first();
                $da = $testResult->user_da;
            @endphp
            <div class="quiz-form__quiz tab-pane fade in" id="question_{{$cauhoi->id}}">
                <p class="quiz-form__question">{{$tmp + (getConfig('number_question_on_page') * ($page - 1))}}: {{ $cauhoi->question }}</p>

                <label class="quiz-form__ans">
                    <input type="radio" name="q1[{{$key}}]" data-question-id="{{$cauhoi->id}}" value="a" {{ $da == "a" ? "checked" : '' }}>
                    <span class="text text-wrong">{{$cauhoi->da_a}}</span>
                </label>

                <label class="quiz-form__ans">
                    <input type="radio" name="q1[{{$key}}]" data-question-id="{{$cauhoi->id}}" value="b" {{ $da == "b" ? "checked" : '' }}>
                    <span class="text text-wrong">{{$cauhoi->da_b}}</span>
                </label>

                <label class="quiz-form__ans">
                    <input type="radio" name="q1[{{$key}}]" data-question-id="{{$cauhoi->id}}" value="c" {{ $da == "c" ? "checked" : '' }}>
                    <span class="text text-wrong">{{$cauhoi->da_c}}</span>
                </label>

                <label class="quiz-form__ans">
                    <input type="radio" name="q1[{{$key}}]" data-question-id="{{$cauhoi->id}}" value="d" {{ $da == "d" ? "checked" : '' }}>
                    <span class="text text-wrong">{{$cauhoi->da_d}}</span>
                </label>
            </div>
        @endforeach
    </div>
</div>
</div>

<script>
    var time_in_minutes = document.getElementById("time_test").value;
    var start_time = document.getElementById("start_time_exam").value;
    var current_time = Date.parse(new Date(start_time));
    var deadline = new Date(current_time + time_in_minutes*60*1000 - 100);

    function time_remaining(endtime){
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor( (t/1000) % 60);

        if(seconds<0){
            location.reload();
        }

        var minutes = Math.floor( (t/1000/60) % time_in_minutes );
        var hours = Math.floor( (t/(1000*60*60)) % 24 );
        var days = Math.floor( t/(1000*60*60*24) );
        //add a leading zero (as a string value) if seconds less than 10
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        return {'total':t, 'days':days, 'hours':hours, 'minutes':minutes, 'seconds':seconds};
    }

    var timeinterval;
    function run_clock(id, endtime){
        var clock = document.getElementById(id);
        function update_clock(){
            var t = time_remaining(endtime);
            clock.innerHTML =  `<p class="clock-count-down"> Thời gian còn lại: `+t.minutes+':'+t.seconds +`</p>`;
            if (t.minutes == 0 && t.seconds == 0) {
                clearInterval(timeinterval);
                alert("Hết giờ, nộp bài thi")
                document.getElementById('formNopbai').submit();
                return;
            }
            if(t.total<=0){ clearInterval(timeinterval); }
        }
        update_clock(); // run function once at first to avoid delay
        timeinterval = setInterval(update_clock,1000);
    }
    run_clock('clockdiv', deadline);
</script>
@endsection
