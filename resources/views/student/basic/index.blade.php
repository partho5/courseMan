@extends('student/basic/base_layout')

@section('title')
    <title>Home</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/css/student/index.css">
@endsection

@section('pageContent')
    <div class="col-md-12" id="container" style="padding: 0">
        <div class="col-md-3 box" id="left-box" style="padding: 0">
            <p id="files" class="text-center hidden"><a href="/file">FILES</a></p>

            <div id="notice-container" class="text-center">
                <h3><a href="/">Notices</a></h3>
                @foreach($notices as $notice)
                    <div class="single-notice-wrapper col-md-12 text-left">
                        <span class="course-title">{{ $notice->course_name }}</span>
                        <p>{{ $notice->title }}</p>
                        <span class="col-md-6 text-left" style="padding: 0"><a href="/notice/{{ $notice->id }}">Details</a></span>
                        <span class="col-md-6 text-right notice-publish-time" title="{{ $notice->created_at }}">{{ \Carbon\Carbon::parse($notice->created_at)->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-7 box" id="middle-box">
            <h1>Show something as initial text</h1>
        </div>

        <div class="col-md-2 box text-center" id="right-box" style="padding: 0">
            <div id="all-courses-wrapper">
                <h3><a href="/">Courses</a></h3>

                {{--@foreach($takenCourses as $course)--}}
                {{--<div class="single-course-wrapper col-md-12 text-left" style="padding: 0" data-toggle="tooltip" title="">--}}
                    {{--<a href="/" class="course-name">{{ $course->courseInfo->course_name }}</a>--}}
                    {{--<span class="arrow bounce hidden"><span class="available-course-notification">5</span></span>--}}
                    {{--<p class="course-code">{{ $course->courseInfo->course_code }}</p>--}}
                    {{--<button class="course-action-btn btn btn-success col-md-10 col-md-offset-1" data-course_id="{{ $course->courseInfo->id }}">Join</button>--}}
                {{--</div>--}}
                {{--@endforeach--}}

                @foreach($allCourses as $course)
                    <div class="single-course-wrapper col-md-12 text-left" style="padding: 0" data-toggle="tooltip" title="">
                        <a href="/course/{{ $course->id }}" class="course-name">{{ $course->course_name }}</a>
                        <span class="arrow bounce hidden"><span class="available-course-notification">5</span></span>
                        <p class="course-code">{{ $course->course_code }}</p>
                        <button class="course-action-btn {{ $course->alreadyTaken ? 'btn-danger':'btn-success' }} btn col-md-10 col-md-offset-1" data-course-id="{{ $course->id }}">{{ $course->alreadyTaken ? 'Leave Course':'Join' }}</button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('.course-action-btn').on('click', function () {
                var courseId = $(this).attr('data-course-id');
                var actionBtnText = $(this).text();
                var THIS = $(this);
                console.log("--"+actionBtnText+"--");
                $.ajax({
                    url : '/course/join_or_leave',
                    type : 'post',
                    data : {
                        _token : "{{ csrf_token() }}", courseId : courseId, actionBtnText : actionBtnText
                    }, success: function (response) {
                        console.log(response);
                        if(response === 'joined course'){
                            THIS.text("Leave Course");
                            THIS.removeClass('btn-success');
                            THIS.addClass('btn-danger');
                        }else if(response === 'left course'){
                            THIS.text("Join");
                            THIS.removeClass('btn-danger');
                            THIS.addClass('btn-success');
                        }
                    }, error : function (a,b,c) {
                        alert("Error. try again");
                    }
                });
            });

        });
    </script>
@endsection