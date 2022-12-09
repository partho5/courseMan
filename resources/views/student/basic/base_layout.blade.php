<!DOCTYPE html>
<html lang="en">
<head>
    @yield('title')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Rajdhani');
        @import url('https://fonts.googleapis.com/css?family=Josefin+Slab');
        @import url('https://fonts.googleapis.com/css?family=Cormorant+Garamond');
        @import url('https://fonts.googleapis.com/css?family=Bungee+Inline');



        #top-bar{
            background-color: rgba(12, 84, 96, 0.76);
            background-color: #384e65;
            color: #ececec;
            font-size: 1.5em;
        }
        #top-bar .menu-item{
            padding: 5px;
        }
        #top-bar .menu-item:hover{
            background-color: #2e4054;
            color: #fff;
            transition: 0.3s;
            cursor: pointer;
        }
        #top-bar .menu-item{
            text-align: center;
        }
        .menu-item a{
            text-decoration: none;
            color: #f4f4f4;
        }
        #top-bar .menu-item:hover{
            color: #fff;
        }
    </style>

    @yield('stylesheet')

</head>
<body>

<div class="container-fluid" style="padding: 0">

    <div id="top-bar" class="col-md-12">
        <div class="col-md-1 menu-item"><a href="/">Home</a></div>
        <div class="col-md-2 menu-item"><a href="">Notice Board</a></div>
        <div class="col-md-1 menu-item"><a href="/settings">Settings</a></div>
    </div>

    @yield('pageContent')
</div>

<script>


    $(document).ready(function () {

    });
</script>

</body>
</html>
