@extends('student/basic/base_layout')

@section('title')
    <title>Settings</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/css/student/settings.css">
@endsection

@section('pageContent')
    <div class="col-md-12" id="container" style="padding: 0">
        <div id="select-batch-wrapper" class="col-md-8 col-md-offset-2">
            <h2 class="text-center">Select My Batch</h2>
            <p class="text-center instruction1">Select one</p>
            @foreach($batches as $batch)
                <div class="single-batch">
                    <input type="radio" name="batch_name" class="batch_name" value="{{ $batch->id }}" {{ $currentBatchId ==  $batch->id ? 'checked':''}}>
                    <span class="batch-name">{{ $batch->batch_name }}</span>
                </div>
            @endforeach
        </div>

        <div id="roll-no-wrapper" class="col-md-8 col-md-offset-2">
            <h2 class="text-center">My Roll No</h2>
            <div class="col-md-12" style="padding: 0">
                <div class="col-md-4" style="padding-left: 0">
                    <label>Roll (Numeric) :</label>
                    <input type="number" min="1" id="roll-numeric" class="form-control" placeholder="Example: 23">
                </div>
                <div class="col-md-5" style="padding-right: 0">
                    <label>Full Form of Roll :</label>
                    <input type="text" class="form-control" id="roll-full-form" placeholder="Example: AB-XY-23">
                </div>
                <div class="col-md-3 text-center" style="padding-right: 0; margin-top: 1.7em;">
                    <button class="btn btn-success" style="width: 8em" id="save_roll_no">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $('.batch_name').click(function () {
                var batchId = $(this).val();
                $.ajax({
                    url   : '/settings/update_my_batch',
                    type : 'post',
                    data : {
                        _token : "{{ csrf_token() }}", batch_id : batchId
                    },
                    success : function (response) {
                        log(response);
                        if(response === 'success'){

                        }else{
                            alert("Error occurred. Reload page and try again");
                        }
                    }, error : function (a, b, c) {
                        log('ajax error');
                    }
                });
            });
            // $('.batch_name').click()


            $('#save_roll_no').click(function () {
                $.ajax({
                    url   : '/settings/save_roll_no',
                    type : 'post',
                    data : {
                        _token : "{{ csrf_token() }}", roll_numeric : $('#roll-numeric').val(), roll_full_form : $('#roll-full-form').val()
                    },
                    success : function (response) {
                        if(response === 'updated' || response === 'saved'){

                        }else{
                            alert("Error occurred. Reload page and try again");
                        }
                    }, error : function (a, b, c) {
                        log('Error. Try again');
                    }
                });
            });
            // $('#save_roll_no').click()




            function log(data) {
                console.log(data);
            }
        });
    </script>
@endsection