<!DOCTYPE html>
<html lang="en">
<head>
    <title>Introduction</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/introduction.css">
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
    <h1>
        <span>CourseMan</span>
    </h1>
    <p id="about-soft"><u>Course Man</u>agement Software</p>

    <div id="features" class="hidden">
        <h3 class="text-center" id="feature-head">Features</h3>
        <ul>
            <li>Hello This is feature 1</li>
            <li>Over a dozen reusable components built to provide iconography</li>
            <li>Includes over 250 glyphs in font format from the</li>
            <li>This isn't too difficult with a little CSS</li>
            <li>Hello This is feature 1</li>
        </ul>
    </div>

    <div class="col-md-12 text-center hidden" id="get-started-wrapper">
        <div class="col-md-4 col-md-offset-4">
            <span>Get Started</span>
        </div>
    </div>

    <div id="about-me-wrapper" class="col-md-12" style="padding: 0px">
        <div class="col-md-8 col-md-offset-2 text-center">
            <div class="col-md-12">
                <div class="col-md-5 student">
                    <a href="/?desired_role={{ (new \App\UserRole())->roleNames()->STUDENT }}">I am a Student</a>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-5 teacher">
                    <a href="/?desired_role={{ (new \App\UserRole())->roleNames()->TEACHER }}">I am a Teacher</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        setTimeout(function () {
            $('#about-me-wrapper').animate({
                opacity:1,
                marginTop:'10%'
            }, function () {
                $('#about-me-wrapper').animate({
                    marginTop:'11%'
                },100);
            });

            $('#menu-bar').animate({
                opacity:1
            });
        },1000);
    });
</script>

</body>
</html>