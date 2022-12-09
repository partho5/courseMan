@extends('student/basic/base_layout')

@section('title')
    <title>Home</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/css/student/course.css">
@endsection

@section('pageContent')
    <div class="col-md-12" id="container" style="padding: 0">
        <div class="col-md-3 box" id="left-box" style="padding: 0">
            <p id="files" class="text-center hidden"><a href="/file">FILES</a></p>

            <div id="notice-container" class="text-center">
                <h3><a href="/">All Notices</a></h3>
                @foreach($notices as $notice)
                    <div class="single-notice-wrapper col-md-12 text-left">
                        <span class="course-title">{{ $notice->course_name }}</span>
                        <p>{{ $notice->title }}</p>
                        <div class="col-md-6 text-left " style="padding: 0">
                            <span class="notice-details-btn">Details</span>
                            <div class="notice-details-box">{{ $notice->details }}</div>
                        </div>
                        <span class="col-md-6 text-right notice-publish-time">{{ \Carbon\Carbon::parse($notice->created_at)->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-7 box" id="middle-box">
            <div id="about-current-course" class="col-md-12" style="padding: 0">
                <h2 class="text-center">{{ $currentPageCourse->course_name }}</h2>
                <p class="text-center course-code">{{ $currentPageCourse->course_code }}</p>

                <div id="current-course-options" class="col-md-12 text-center" style="padding: 0">
                    <div class="col-md-3">
                        Total Class : {{ $currentPageCourse->total_class }}
                    </div>
                    <div class="col-md-3">
                        Class held: {{ $totalClassHeld }}
                    </div>
                    <div class="col-md-3">
                        Attended : {{ $attendedClass }}
                    </div>
                    <div class="col-md-3">
                        Percentage : {{ $attendancePercent }}%
                    </div>
                </div>
            </div>

            <div id="thread-wrapper" class="col-md-12" style="padding: 0">

                @foreach($singleCourseNotices as $notice)
                    <div class="single-post-wrapper col-md-12" style="padding: 0">
                        {{--<div class="col-md-2" style="padding: 0">--}}
                            {{--<img src="/images/habibur.jpg" class="img-responsive">--}}
                        {{--</div>--}}

                        <div class="col-md-12 post-body-wrapper" style="padding: 0">
                            <p class="post-head">
                                <span class="course-teacher-name hidden"><b>Dr Md. Habibur Rahman</b></span>
                                <span class="post-time">{{ \Carbon\Carbon::parse($notice->created_at)->diffForHumans() }}</span>
                            </p>
                            <div class="post-content">
                                <p>{{ $notice->title }}</p>
                                <p>{{ $notice->details }}</p>
                            </div>
                        </div>

                        @for($i=0;$i<0;$i++)
                            <div class="col-md-12 single-comment-wrapper" style="padding: 0">

                                <div class="col-md-2 commenter-name" style="padding: 0;"></div>

                                <div class="col-md-10 comment-content-wrapper" style="padding: 0">
                                    <div class="">
                                        <div class="comment-head">
                                            <span class="commenter-name"><a href="">Partho protim</a></span>
                                            <span class="commenter-time" data-toggle="tooltip" title="19/2/18">27 min ago</span>

                                            <div class="commenter-profile-info hidden">
                                                <p class="text-center loading-text">Loading...</p>
                                            </div>
                                        </div>

                                        <div class="comment-content">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor

                        <div class="col-md-12 hidden" style="padding: 0;">
                            <div class="col-md-2" style="padding: 0;"></div>
                            <div class="col-md-8 comment-field" style="padding: 0;">
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-2 text-right comment-btn-wrapper" style="padding: 0;"><button>Comment</button></div>
                        </div>
                    </div>
                @endforeach

            </div>
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
            }); //.course-action-btn

            $('.notice-details-btn').click(function () {
                $(this).next('.notice-details-box').show();
            });

        });
    </script>
@endsection