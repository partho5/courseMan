<!DOCTYPE html>
<html lang="en">
<head>
    <title>Initial Setup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">

    <style>
        body{
            background-color: #eeeeee;
        }
        #page-content{
            margin-top: 4em;
        }
        #config-window{
            margin-top: 2em;
            border: 1px solid rgba(132, 178, 180, 0.91);
            background-color: #fff;
        }
        .heading-bar{
            background-color: rgba(132, 178, 180, 0.15);
            border-bottom: 1px solid rgb(136, 183, 185);
            font-family: 'Play', sans-serif;
        }
        .heading-bar h3{
            color: #007678;
            margin: 0.3em 0.6em;
        }
        .main-content{
            margin-top: 1em;
        }
        .form-group{
            font-size: 1.3em;
        }
        .bottom-bar{
            margin: 1em 0;
        }
        .bottom-bar a{
            text-decoration: none;
            padding: 5px 0;
        }
        .highlighted-bottom-btn{
            background-color: rgba(230,90,0,0.9);
            color: #fff;
        }
        .highlighted-bottom-btn:hover{
            color: #fff;
        }

        .btn1{
            background-color: rgba(0,156,184,0.89);
            color: #f9f9f9;
            border-radius: 0;
            margin-bottom: 0.4em;
            padding: 5px 2em;
            font-size: 1.8em;
        }
        .btn1:hover{
            color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container-fluid col-md-12" style="padding: 0px">
    <nav class="navbar navbar-default navbar-fixed-top" id="menu-bar" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/" >CourseMan</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/register">Register</a></li>
                    <li><a href="/login">Login</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="col-md-12 text-center" id="page-content">

        <?php
            $configStep = @$_GET['step'];
            if($configStep > 3){
                $configStep = 1;
            }
        ?>

        <div id="config-window" class="col-md-8 col-md-offset-2" style="padding: 0">
            <div class="heading-bar col-md-12 text-left" style="padding: 0">
                <div class="col-md-10" style="padding: 0">
                    <h3>Configure CourseMan</h3>
                </div>
                <div class="col-md-2" style="padding: 0">
                    <h3>Step {{ $configStep }}/3</h3>
                </div>
            </div>

            <div class="col-md-12 main-content text-left" style="padding: 0">
                @if($configStep == 1)
                <form method="post" action="/configure_step1">
                {{ csrf_field() }}
                <div class="step-1 col-md-12" style="padding: 0">
                    <div class="form-group col-md-12">
                        <div class="input-group col-md-12">
                            <span>University Name</span>
                            <input type="text" class="form-control" name="univ_name" value="{{ \Session::get('univ_name')}}">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <div class="input-group col-md-12">
                            <span>Department Name</span>
                            <input type="text" class="form-control" name="dept_name" value="{{ \Session::get('dept_name')}}">
                        </div>
                    </div>

                    <div class="col-md-12 bottom-bar text-center">
                        <a href="?step=0" class="col-md-2">

                        </a>
                        <div class="col-md-8"></div>
                        {{--<a href="?step=2" class="col-md-2 highlighted-bottom-btn">--}}
                            {{--Next <span class="glyphicon glyphicon-forward"></span>--}}
                        {{--</a>--}}
                        <input type="submit" value="Next >" class="btn col-md-2 highlighted-bottom-btn">
                    </div>
                </div>
                </form>
                @endif

                @if($configStep == 2)
                <form method="post" action="/configure_step2">
                {{ csrf_field() }}
                <div class="step-2 col-md-12" style="padding: 0">
                    <div class="form-group col-md-12">
                        <div class="input-group col-md-12">
                            <span>Number of running batches in department</span>
                            <input type="number" name="num_of_batches" min="1" id="num-of-running-batches" class="form-control" value="{{ \Session::get('num_of_batches') }}">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <p>Running batch names</p>
                        <div class="input-group col-md-12 running-batch-fields-wrapper">
                            <?php
                                $batchNames =Session::get('batch_name');
                                $placeHolders = ['1st Year', '2nd Year', '3rd Year', '4th Year', 'Masters', '','','','','','','','','','','','','',''];
                                $i=0;
                            ?>
                            @if(count($batchNames) > 0)
                                @foreach($batchNames as $batchName)
                                    <div class="col-md-4 running-batch-name" style="padding: 0">
                                        <input type="text" name="batch_name[]" class="form-control" placeholder="{{ $placeHolders[$i++] }}" value="{{ $batchName }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <div class="input-group col-md-12">
                            <span>Students per batch</span>
                            <input type="number" name="students_per_batch" min="1" class="form-control" value="{{ \Session::get('students_per_batch') }}">
                        </div>
                    </div>

                    <div class="col-md-12 bottom-bar text-center">
                        <a href="?step=1" class="col-md-2">
                            <span class="glyphicon glyphicon-backward"></span> Back
                        </a>
                        <div class="col-md-8"></div>
                        {{--<a href="?step=3" class="col-md-2 highlighted-bottom-btn">--}}
                            {{--Next <span class="glyphicon glyphicon-forward"></span>--}}
                        {{--</a>--}}
                        <input type="submit" value="Next >" class="btn col-md-2 highlighted-bottom-btn">
                    </div>
                </div>
                </form>
                @endif

                @if($configStep == 3)
                <form method="post" action="/configure_step3">
                {{ csrf_field() }}
                <div class="step-3 col-md-12" style="padding: 0">

                    <div class="form-group col-md-12">
                        <div class="input-group col-md-12">
                            <span>Minimum % of attendance</span>
                            <input type="number" name="min_percent_of_attendance" min="0" class="form-control" value="{{ \Session::get('min_percent_of_attendance') }}">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <div class="input-group col-md-12">
                            <span>Marks in attendance</span>
                            <input type="number" name="marks_in_attendance" min="0" class="form-control"  value="{{ \Session::get('marks_in_attendance') }}">
                        </div>
                    </div>

                    <div class="col-md-12 bottom-bar text-center" style="padding: 0">
                        <a href="?step=2" class="col-md-2">
                            <span class="glyphicon glyphicon-backward"></span> Back
                        </a>
                    </div>

                    {{--<div class="col-md-4 col-md-offset-4 text-center">--}}
                        {{--<a href="" class="btn btn1">Finish</a>--}}
                    {{--</div>--}}
                    <div class="col-md-4 col-md-offset-4 text-center">
                        <input type="submit" value="Finish" class="btn btn1">
                    </div>
                </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {


        $('#num-of-running-batches').change(function () {
            var numOfRunningBatches = $(this).val();
            $('.running-batch-name').each(function () {
                $(this).remove();
            });
            for(var i=0; i< numOfRunningBatches; i++){
                var suggestedBatchName = ['1st Year', '2nd Year', '3rd Year', '4th Year','Masters ...etc','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',];
                $('.running-batch-fields-wrapper').append(
                    '<div class="col-md-4 running-batch-name" style="padding: 0">'+
                    '<input type="text" name="batch_name[]" class="form-control" placeholder="'+(suggestedBatchName[i])+'">'+
                    '</div>'
                );
            }
        });
    });
</script>

</body>
</html>