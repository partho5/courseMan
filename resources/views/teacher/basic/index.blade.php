@extends('teacher/basic/base_layout')

@section('title')
    <title>Home</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/css/teacher/index.css">
@endsection

@section('pageContent')

<div class="col-md-12 text-center" id="institute-intro">
    <div id="about-me" class="text-left">
        <a href="/"><img src="{{ url('/') }}{{ $profilePicUrl or "" }}" alt="image" class="pp"></a>
        <p class="name"><a href="/">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a></p>
        {{--<p class="designation">Professor</p>--}}
    </div>

    <p><span class="dept-name" data-toggle="tooltip" title="">{{ $instituteInfo->dept_name }}</span></p>
    <p class="univ-name">{{ $instituteInfo->univ_name }}</p>

    <div id="change-institution-btn">
        <a href="/">Change Department</a>
    </div>
</div>

<div class="col-md-6 box" id="box1">
    <h2 class="text-center">Create New Notice</h2>

    <div id="notice-publish-loader" class="text-center">
        <span class="glyphicon glyphicon-remove cross"></span>
        <p id="publishing"></p>
        <p id="published-msg">Notice published !</p>
    </div>

    <div id="notification-wrapper">
        <div class="col-md-12 form-group" style="padding: 0">
            Title
            <input type="text" class="form-control" id="notice-title">
        </div>

        <div class="col-md-12 form-group" style="padding: 0">
            Details <small class="faded-text"> (Optional)</small>
            <textarea name="" id="notice-details-field" class="form-control" rows="4" ></textarea>
        </div>

        <div class="col-md-12 form-group hidden" style="padding: 0">
            Upload File <small class="faded-text"> (Optional)</small>
            <input type="file" class="form-control">
            <div class="col-md-12" id="notice-upload-file-bar">0%</div>
        </div>

        <div class="col-md-12 form-group hidden" style="padding: 0">
            <div class="col-md-5" style="padding: 0px">
                <input type="checkbox"> Publish in future
            </div>
            <div class="col-md-7" style="padding: 0px">
                <input type="datetime" class="form-control">
            </div>
        </div>

        <div class="col-md-12 form-group hidden" style="padding: 0">
            <div class="col-md-3">Notify via</div>
            <div class="col-md-3"><input type="checkbox"> Email</div>
            <div class="col-md-4"><input type="checkbox"> Push Notification</div>
            <div class="col-md-2"><input type="checkbox"> SMS</div>
        </div>

        @if(count($courses))
            <div id="course-names-wrapper" class="col-md-12 form-group" style="padding: 0">
                <p>Notify students who have :</p>
                @foreach($courses as $course)
                    <div class="single-course-name col-md-12" style="padding: 0">
                        <input type="checkbox" name="batch_id" class="course-id" value="{{ $course->id }}">
                        <span class="course-name" data-toggle="tooltip" title="{{ $course->course_code }}">{{ $course->course_name }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <button class="btn btn-success col-md-4 col-md-offset-4" id="publish-notice">Publish Notice</button>

        <div class="col-md-12 hidden" style="padding: 0" id="notification-wrapper">
            <br> <p style="display: block; height: 2px; background-color: rgba(0,102,124,0.56);"></p>
            <ul style="padding: 0; margin: 2px">
                <li class="list-group-item col-md-12" style="padding: 0px 0px 0px 10px">
                    <p class="text-left">Class Calcel date fixed : 30 April, 2018</p>
                    <div class="col-md-12" style="padding: 0; margin: 0">
                        <p class="col-md-6">
                            <a href="/" class="posted-by">Partho Protim</a>
                            <span class="posted-at">3 hours ago</span>
                        </p>
                        <span class="col-md-6 text-right"><a href="" class="all-post-by"><small>all posts by</small> Partho Protim</a></span>
                    </div>
                </li>


                <li class="list-group-item col-md-12" style="padding: 0px 0px 0px 10px">
                    <p class="text-left">I will not take the class tomorrow. Rather I will take it on 25 April</p>
                    <div class="col-md-12" style="padding: 0; margin: 0">
                        <p class="col-md-6">
                            <a href="/" class="posted-by">Mainul Islam</a>
                            <span class="posted-at">3 hours ago</span>
                        </p>
                        <a href="/" class="all-post-by col-md-6 text-right"><small>all posts by</small> Partho Protim</a>
                    </div>
                </li>

                <li class="list-group-item col-md-12" style="padding: 0px 0px 0px 10px">
                    <p class="text-left">I will not take the class tomorrow. Rather I will take it on 25 April</p>
                    <div class="col-md-12" style="padding: 0; margin: 0">
                        <p class="col-md-6">
                            <a href="/" class="posted-by">Partho Protim</a>
                            <span class="posted-at">3 hours ago</span>
                        </p>
                        <a href="/" class="all-post-by col-md-6 text-right"><small>all posts by</small> Partho Protim</a>
                    </div>
                </li>

                <li class="list-group-item col-md-12" style="padding: 0px 0px 0px 10px">
                    <p class="text-left">I will not take the class tomorrow. Rather I will take it on 25 April</p>
                    <div class="col-md-12" style="padding: 0; margin: 0">
                        <p class="col-md-6">
                            <a href="/" class="posted-by">Partho Protim</a>
                            <span class="posted-at">3 hours ago</span>
                        </p>
                        <a href="/" class="all-post-by col-md-6 text-right"><small>all posts by</small> Partho Protim</a>
                    </div>
                </li>

            </ul>
        </div>


    </div>
</div>

<div class="col-md-6 box" id="box2" >
    <div class="col-md-12 text-center plate-wrapper hidden" style="padding: 0px">
        <a href="/file" class="col-md-6 plate plate1" style="padding: 0px">
            <h3 style="font-size: 1.6em"><span class="first-letter">S</span>hare <span class="first-letter">F</span>ile</h3>
        </a>

        <a href="/" class="col-md-6 plate plate2" style="padding: 0px">
            <h3 style="font-size: 1.6em"><span class="first-letter">T</span>alk <span class="first-letter">T</span>o <span class="first-letter">S</span>tudents</h3>
        </a>
    </div>

    <div class="col-md-12" style="padding: 0px" id="my-courses-wrapper">
        <h4 class="text-center" id="my-course-heading">My Courses</h4>
        <a href="/course/create" id="add-course">
            <span class="glyphicon glyphicon-plus"></span>
            Add Course
        </a>
        @foreach($courses as $course)
            <div class="col-md-12 single-course-wrapper" style="padding: 0.3em 0px">
                <p class="col-md-7 course-name">{{ $course->course_name }}</p>
                <p class="col-md-3 course-code">{{ $course->course_code }}</p>
                <p class="col-md-2 course-student-num"  title="remaining classes: {{ $course->total_class - $totalClassHeld[$course->id] }}">{{ $totalClassHeld[$course->id] }}/{{ $course->total_class }}</p>

                <div class="col-md-12 options" style="padding: 0.5em 0px">
                    <div class="col-md-3">
                        <a class="glyphicon glyphicon-edit course-edit-btn" href="/course/{{ $course->id }}/edit" data-toggle="tooltip" title="Edit"></a>
                        <form action="{{ URL::route('course.destroy', $course->id) }}" method="POST" style="float: left" class="course-delete-btn">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="glyphicon glyphicon-trash" style="background-color: #fff; border: 0; margin-top: 4px"></button>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <a class="glyphicon glyphicon-stats course-statistics" data-toggle="tooltip" title="Statistics"></a>
                        <a href="/course/ct/create?id={{ $course->id }}" style="border: 1px solid #e1e1e1; background-color: rgba(209,209,209,0.31)">
                            <span class="glyphicon glyphicon-text-color course-assignment" data-toggle="tooltip" title="Assignment"></span>
                            &
                            <span class="glyphicon glyphicon-book course-assignment" data-toggle="tooltip" title="Exam Marks"></span>
                        </a>
                        {{--<a href="" data-toggle="tooltip" title="Incourse"><img src="/images/ppt.jpg" alt="" width="18px" height="18px" class="course-presentation"></a>--}}
                    </div>
                    <div class="col-md-4 hidden">
                        <a class="glyphicon glyphicon-align-center course-syllabus" data-toggle="tooltip" title="Syllabus"></a>
                        <a href="/" class="glyphicon glyphicon-calendar course-routine" data-toggle="tooltip" title="Routine"></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


<script src="/js/lib/typer.js"></script>
<script>
    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();

        $("#notice-publish-loader #publishing").typer({
            strings: ["Publishing Notice", "Please wait", "It will take a little time"],
            typeSpeed: 60,
            backspaceSpeed: 20,
            backspaceDelay: 800,
            repeatDelay: 500,
            repeat: true,
            autoStart: true,
            startDelay: 1000,
        });


        $("#publish-notice").click(function () {
            $("#notice-publish-loader").show();
            $("#notice-publish-loader").animate({
                top : "20%",
                opacity : 1
            }, 300, function () {
                $("#notice-publish-loader").animate({
                    top : "15%",
                },100, function () {
                    $("#notice-publish-loader").animate({
                        top : "16%",
                    },50);
                    $("#notice-publish-loader #publishing").hide();
                    $("#notice-publish-loader").css('background-color', '#f1f1f1');
                });
            });

            var title = $('#notice-title').val();
            var details = $('#notice-details-field').val();
            var courseIdToNotify = [];
            $('.course-id').each(function () {
                if(this.checked){
                    courseIdToNotify.push($(this).val());
                }
            });

            $.ajax({
                url : '/notice',
                type : 'post',
                dataType : 'text',
                data : {
                    _token : "{{ csrf_token() }}", title : title, details : details, courseIdToNotify : JSON.stringify(courseIdToNotify)
                }, success : function (response) {
                    console.log(response);
                }, error : function (a, b, c) {
                    alert("Error occurred. Try again");
                }
            });
        }); // #publish-notice click

        $('#notice-publish-loader .cross').click(function () {
            $('#notice-publish-loader').animate({
                top : "-100%",
                opacity : 1
            });

            //empty all text fields
            $('#notice-title').val("");
            $('#notice-details-field').val("");
            $('input:checkbox').removeAttr('checked');
        });


//        $('#institute-intro .dept-name').click(function () {
//            $('#change-institution-btn').animate({
//                top : '0',
//                opacity:1
//            });
//        });

        $(document).click(function () {
            if($('#change-institution-btn').css('opacity') == 1){
                $('#change-institution-btn').animate({
                    top : '-5em',
                    opacity:0
                },200);
            }
        });
        $(document).keyup(function(e) {
            if (e.keyCode == 27) { // escape key maps to keycode `27`
                $('#change-institution-btn').animate({
                    top : '-5em',
                    opacity:0
                },200);
            }
        });


    });
</script>

@endsection
