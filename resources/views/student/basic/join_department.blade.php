<!DOCTYPE html>
<html lang="en">
<head>
    <title>Join</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <style>
        body{
            background-color: #f8f8f8;
        }
        h1{
            color: #00afcb;
        }
        h3{
            color: #808080;
        }
        #join_token{
            border-radius: 0;
        }
        .btn1{
            background-color: rgba(0, 156, 184, 0.82);
            color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #f8f8f8;
            margin-bottom: 0.4em;
            padding: 5px 2em;
            font-size: 1.8em;
        }
        .btn1:hover{
            color: #f9f9f9;
            background-color: rgb(0, 156, 184);
            border-radius: 0;
            border: 1px solid #008ea7;
        }
    </style>
</head>
<body>
    <div id="container" class="col-md-12" style="padding: 0">
        <h1 class="text-center">Join Your Department</h1>
        <div class="text-center col-md-12">
            <h3>Authentication Code :</h3>
            <form method="post" action="/join_dept">
                {{ csrf_field() }}
                <div class="form-group col-md-6 col-md-offset-3">
                    <input type="text" class="form-control" id="join_token" name="join_token">
                </div>

                <div class="form-group col-md-6 col-md-offset-3">
                    <input type="submit" value="Join" id="join_btn" class="btn btn1">
                </div>
            </form>

            @if(\Session::has('msg'))
                <div class="col-md-6 col-md-offset-3">
                    <p class="alert alert-danger"><b>{!! \Session::get('msg') !!}</b></p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>