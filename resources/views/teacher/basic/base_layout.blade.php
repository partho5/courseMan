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
        //-ms-transform: scale(1.3); /* IE 9 */
        //-webkit-transform: scale(1.3); /* Safari 3-8 */
        //transform: scale(1.3);
            background-color: #2e4054;
            color: #fff;
            transition: 0.3s;
            cursor: pointer;
        }
        /*
        #top-bar .menu-item:nth-child(1){
            cursor:  e-resize;
        }
        #top-bar .menu-item:nth-child(2){
            cursor:  se-resize;
        }
        #top-bar .menu-item:nth-child(3){
            cursor:  sw-resize;
        }
        #top-bar .menu-item:nth-child(4){
            cursor:  w-resize;
        }
        */

        #top-bar{
            padding: 0.3em 1em;
        }
        #top-bar .menu-item{
            text-align: center;
            padding-right: 1em;
        }
        .menu-item a{
            text-decoration: none;
            color: #f4f4f4;
        }
        #top-bar .menu-item:hover{
            color: #fff;
        //text-shadow: 1px 1px #000;
        }
        #institute-intro{

            font-family: 'Bungee Inline', cursive;

            background: url("/images/bg3.jpeg");
        //background-size: cover;

            font-size: 2em;
            color: #008dcd;
        }
    </style>

    @yield('stylesheet')

</head>
<body>

<div class="container-fluid" style="padding: 0">

    <div id="top-bar" class="col-md-12">
        <span class=" menu-item"><a href="/">Home</a></span>
        <span class=" menu-item hidden"><a href="">Notice</a></span>
        <span class=" menu-item"><a href="/settings">Settings</a></span>
        <span class=" menu-item"><a href="/roles">Manage Roles</a></span>
    </div>

    @yield('pageContent')
</div>

<script>


    $(document).ready(function () {

    });
</script>

</body>
</html>
