<html>
<head>
    <title>CourseMan</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <style>
        body {
            padding: 0;
            margin: 0;
            background-color: #eee;
        }
        .bg-design {
            background-color: #e5e5e5;
            margin-left: 15%;
            margin-right: 15%;
            /*border: 2px solid #0f0; */
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }

        #box1{
            color: #fff;
            background-color: rgba(0, 169, 196, 0.78);
            padding: 1px 0px;
            margin-bottom: 2px;
            font-size: 4vh;
        }
        #heading{
            font-family: 'Nunito', sans-serif;
        }
        #box2{
            background-color: rgba(246, 246, 246, 0.78);
            padding: 1vh 2vh;
            font-size: 3vh;
        }
        @media only screen and (max-width: 600px) {
            .images {
                width: 100%;
            }

            .bg-design {
                margin-left: 2px;
                margin-right: 2px;
                /* border: 2px solid #0f0; */
            }
            #heading{
                font-family: fantasy;
            }
        }
        .p2{
            text-align: left;
            font-family:'Roboto';
        }
        .p2 .published-by{
            color: #0034a8;
            font-size: 2.5vh;
        }
        .p2 .publish-date{
            color: #818181;
            font-size: 1.8vh;
            margin-left: 4vh;
        }
        .p2 .publish-time{
            color: #818181;
            font-size: 1.8vh;
            margin-left: 1vh;
        }
    </style>
</head>
<body>
<div class="bg-design">
    <div id="box1" class="text-center">
        <p id="heading">{{ $noticeData['title'] }}</p>
    </div>

    <div id="box2" class="text-center">
        <p class="p1 text-left">{{ $noticeData['details'] }}</p>

        <p class="p2">
            <span class="published-by">{{ $noticeData['created_by'] }}</span>
            <span class="publish-date">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
            <span class="publish-time">{{ \Carbon\Carbon::now()->format('g:i A') }}</span>
        </p>
    </div>
</div>

</body>
</html>