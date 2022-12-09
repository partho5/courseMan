@extends('teacher.basic.base_layout')

@section('title')
    <title>Add Course</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/css/teacher/course.css">
@endsection

@section('pageContent')
    <div class="col-md-12" id="container" >
        @if(\Session::has('msg'))
            <div class="col-md-8 col-md-offset-2 alert alert-success">
                {!! \Session::get('msg') !!}
            </div>
        @endif
        <div id="course-wrapper" class="col-md-8 col-md-offset-2" style="padding: 0px">
            <div class="container">
                <h2>Add a New Course<small></small></h2>
                <form method="post" action="/course">
                    {{ csrf_field() }}
                    <div class="group">
                        <input type="text" name="course_name" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Course name</label>
                    </div>

                    <div class="group">
                        <input type="text" name="course_code" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Course code</label>
                    </div>

                    <div class="group">
                        <input type="number" name="total_class" min="1" value="30" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Num of total classes</label>
                    </div>

                    <div class="group">
                        <input type="number" name="min_percent_of_attendance" min="0" value="5" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Minimum % of attendance</label>
                    </div>

                    <div class="group hidden">
                        <textarea name="" id="" rows="3" class="form-control" placeholder="Optional"></textarea>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Syllabus <small>( Text / file link )</small></label>
                    </div>

                    <div class="form-group col-md-4 col-md-offset-5">
                        <div class="input-group">
                            <input type="submit" value="Save Course" id="save-course-btn" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection