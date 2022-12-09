@extends('teacher.basic.base_layout')

@section('title')
    <title>Class Test</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/css/teacher/class_test.css">
@endsection

@section('pageContent')
    <div class="col-md-12 text-center" id="container">
        <h2>Marks Calculation</h2>
        <table class="table" id="marks-table">
            <tr class="heading-row">
                <td class="sr">Sr.</td>
                <td class="roll-no">Roll No.</td>
                <td class="name">Name</td>
                <td class="ct ct-1">Incourse 1</td>
                <td class="ct ct-2">Incourse 2</td>
                <td class="attendance">Attendance</td>
                <td class="assignment assignment-1">Assignment 1</td>
                <td class="assignment assignment-2">Assignment 2</td>
                <td class="assignment assignment-3">Assignment 3</td>
                <td class="total">Total</td>
                <td class="note">Note</td>
            </tr>

            <?php $i=0; ?>
            @foreach($users as $user)
                <?php
                try{
                    $ct1 = $marks[$i][$user->user_id]->ct1;
                    $ct2 = $marks[$i][$user->user_id]->ct2;
                    $assignment1 = $marks[$i][$user->user_id]->assignment1;
                    $assignment2 = $marks[$i][$user->user_id]->assignment2;
                    $assignment3 = $marks[$i][$user->user_id]->assignment3;
                    $note = $marks[$i][$user->user_id]->note;
                }catch(Exception $e){}
                ?>
                <tr class="mark-row" data-user-id="{{ $user->user_id }}">
                    <td class="sr">{{ ++$i }}</td>
                    <td class="roll-no"><input type="text" value="{{ $user->roll_full_form }}" disabled></td>
                    <td class="name">{{ $user->name }}</td>
                    <td class="ct ct-1"><input type="number" step="0.5" value="{{ $ct1 or ""}}"></td>
                    <td class="ct ct-2"><input type="number" step="0.5" value="{{ $ct2 or ""}}"></td>
                    <td class="attendance" title="{{ $attendancePercent[$user->user_id] or 0 }} %, present in {{ $numOfClassAttended[$user->user_id] or 0}} classes"><input type="number" disabled step="0.5" value="{{ $attendanceMarks[$user->user_id] or 0 }}"></td>
                    <td class="assignment assignment-1"><input type="number" step="0.5" value="{{ $assignment1 or ""}}"></td>
                    <td class="assignment assignment-2"><input type="number" step="0.5" value="{{ $assignment2 or ""}}"></td>
                    <td class="assignment assignment-3"><input type="number" step="0.5" value="{{ $assignment3 or ""}}"></td>
                    <td class="total"><input type="number" step="0.5" value="" disabled></td>
                    <td class="note"><input type="text" value="{{ $note or ""}}"></td>
                </tr>
            @endforeach
        </table>

        <button class="btn btn1" id="save-marks-data-btn">Save All Data</button>

    </div>

    <script>
        $(document).ready(function () {

            $('#marks-table .mark-row').each(function () {
                var ct1Mark = $(this).children().eq(3).children('input').val();
                var ct2Mark = $(this).children().eq(4).children('input').val();
                var attendanceMark = $(this).children().eq(5).children('input').val();
                var assignment1Mark = $(this).children().eq(6).children('input').val();
                var assignment2Mark = $(this).children().eq(7).children('input').val();
                var assignment3Mark = $(this).children().eq(8).children('input').val();

                var total = (parseFloat(ct1Mark) || 0)+ (parseFloat(ct2Mark) || 0)+ (parseFloat(attendanceMark) || 0) +
                    (parseFloat(assignment1Mark) || 0)+ (parseFloat(assignment2Mark) || 0)+ (parseFloat(assignment3Mark) || 0);
                $(this).children().eq(9).children('input').val(Math.ceil(total));
            });


            $('#save-marks-data-btn').click(function () {
                var marks = [];
                $('#marks-table .mark-row').each(function () {
                    var userId = $(this).attr('data-user-id');
                    var ct1Mark = $(this).children().eq(3).children('input').val();
                    var ct2Mark = $(this).children().eq(4).children('input').val();
                    var attendanceMark = $(this).children().eq(5).children('input').val();
                    var assignment1Mark = $(this).children().eq(6).children('input').val();
                    var assignment2Mark = $(this).children().eq(7).children('input').val();
                    var assignment3Mark = $(this).children().eq(8).children('input').val();
                    var totalMark = $(this).children().eq(9).children('input').val();
                    var note = $(this).children().eq(10).children('input').val();

                    var row = {
                        userId:userId, ct1Mark:ct1Mark, ct2Mark:ct2Mark, attendanceMark:attendanceMark,
                        assignment1Mark:assignment1Mark, assignment2Mark:assignment2Mark, assignment3Mark:assignment3Mark,
                        totalMark:totalMark, note:note
                    };
                    marks.push(row);
                }); // each()

                //console.log(marks);
                $.ajax({
                    url : '/course/ct',
                    type : 'post',
                    data : {
                        _token : "{{ csrf_token() }}", courseId : "{{ app('request')->input('id') }}", marks : marks
                    }, success:function (response) {
                        console.log(response);
                        alert("Saved");
                    }, error : function () {
                        alert("Error. Try again");
                    }
                });
            });


            $(':input').bind('keyup change', function () {
                var THIS = $('#marks-table .mark-row');
                THIS = $(this).parent().parent();

                var ct1Mark = THIS.children().eq(3).children('input').val();
                var ct2Mark = THIS.children().eq(4).children('input').val();
                var attendanceMark = THIS.children().eq(5).children('input').val();
                var assignment1Mark = THIS.children().eq(6).children('input').val();
                var assignment2Mark = THIS.children().eq(7).children('input').val();
                var assignment3Mark = THIS.children().eq(8).children('input').val();

                var total = (parseFloat(ct1Mark) || 0)+ (parseFloat(ct2Mark) || 0)+ (parseFloat(attendanceMark) || 0) +
                    (parseFloat(assignment1Mark) || 0)+ (parseFloat(assignment2Mark) || 0)+ (parseFloat(assignment3Mark) || 0);

                THIS.children().eq(9).children('input').val(Math.ceil(total));
            });

        });
    </script>


@endsection