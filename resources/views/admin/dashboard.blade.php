@extends('layouts.admin')
@section('title', 'Dashboard - Talkiyon Admin')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/plugins/clock/clock.css')}}">
@endsection
@section('content')
    <div class="row p-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-3">
            <div class="card bg-dark">
                <div class="card-body" style="display: flex;justify-content: center;align-items: center;">
                    <span style=" color: #AAA;font-size: 50px;">Students: </span><span id="student_counter" class="count" style=" color: #AAA;font-size: 60px; font-weight: bolder">0</span>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-3">
            <div class="card bg-dark">
                <div class="card-body" style="display: flex;justify-content: center;align-items: center;">
                    <span style=" color: #AAA;font-size: 50px;">Teachers: </span><span id="teacher_counter" class="count" style=" color: #AAA;font-size: 60px; font-weight: bolder">0</span>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div id="date" class="date"></div>
        <div id="time" class="time"></div>
    </div>


@endsection
@section('script')
    <script src="{{asset('assets/plugins/counter_effect/counter_effect.js')}}"></script>
    <script src="{{asset('assets/plugins/clock/clock.js')}}"></script>
    <script>
        $(document).ready (function () {
            clock.display('date', 'time');
            $.ajax ({
                url: '{{route('admin.dashboard.content')}}',
                type: 'GET'
            }).done (function (response) {
                if (response.success) {
                    $('#student_counter').html(response.data.student_count);
                    $('#teacher_counter').html(response.data.teacher_count);
                    counterEffect('.count');
                } else {
                    console.log(response.message);
                }
            }).fail (function (error) {
                console.log(error);
            });
        });
    </script>
@endsection
