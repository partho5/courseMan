<!DOCTYPE html>
<html lang="en">
<head>
    <title>CourseMan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <style>
        #page-content{
            margin-top: 4em;
        }
        #decide-actions-wrapper .join-btn, .configure-btn{
            font-size: 2em;
            padding: 0.4em 0px;
            margin-top: 1.5em;
        }
        .join-btn{
            background-color: rgba(21, 127, 121, 0.7);
            color: #f3f3f3;
            border: 1px solid #188e88;
            box-shadow: 2px 2px 5px 0px #878a87;
        }
        .configure-btn{
            background-color: rgba(203, 101, 63, 0.86);
            color: #f3f3f3;
            border: 1px solid #e47147;
            box-shadow: 2px 2px 5px 0px #878a87;
        }
        .join-btn, .configure-btn{
            cursor: pointer;
        }
        .join-btn:hover{
            background-color: rgb(26, 161, 168);
        }
        .configure-btn:hover{
            background-color: rgb(213, 106, 66);
        }
        #join-window{
            margin-top: 5px;
            border: 1px solid #dcdcdc;
            background-color: #f9f9f9;
            font-size: 1.4em;
            display: none;
        }
        #configure-window{
            margin-top: 5px;
            border: 1px solid #dcdcdc;
            background-color: #f9f9f9;
            font-size: 1.4em;
            display: none;
        }
        .btn1{
            background-color: rgba(0,156,184,0.89);
            color: #f9f9f9;
            border-radius: 0;
            margin-top: 1em;
            margin-bottom: 0.4em;
            font-size: 1.3em;
        }
        .btn1:hover{
            color: #f9f9f9;
        }
        .btn2{
            background-color: rgba(239,94,0,0.8);
            color: #f9f9f9;
            border-radius: 0;
            margin-bottom: 0.4em;
            font-size: 1.5em;
        }
        .btn2:hover{
            color: #f9f9f9;
            background-color: rgba(239,94,0);
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
        <div id="decide-actions-wrapper" class="col-md-12" style="padding: 0">
            <div class="col-md-10 col-md-offset-1 text-center">
                <div class="col-md-12">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-12">
                            @if(\Session::has('msg'))
                                <div class="col-md-6 col-md-offset-3">
                                    <p class="alert alert-danger"><b>{!! \Session::get('msg') !!}</b></p>
                                </div>
                            @endif
                        </div>
                        <div class="join-btn">My Department Uses This Software. Now Join</div>
                        <div id="join-window">
                            <form method="post" action="/join_dept">
                                {{ csrf_field() }}
                                <div class="input-group col-md-10 col-md-offset-1">
                                    <p class="text-left">Enter the authentication code :</p>
                                    <input type="text" name="join_token" class="form-control" placeholder="Authentication Code">
                                </div>

                                <div class="input-group col-md-12">
                                    <input type="submit" class="btn btn1" value="Join My Department">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-8 col-md-offset-2">
                        <div class="configure-btn">My Department Wants To Use This Software</div>
                        <div id="configure-window">
                            <br><p style="color: #e65a00"><b>No download + No installation + No maintain = No pain </b></p>
                            <p style="color: rgb(134,134,134)">Just</p>
                            <a href="/configure?step=1"><span class="btn btn2">Configure The Software</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.join-btn').click(function () {
            $('#join-window').slideToggle();
            $('#configure-window').slideUp();
        });

        $('.configure-btn').click(function () {
            $('#configure-window').slideToggle();
            $('#join-window').slideUp();
        });
    });
</script>

</body>
</html>