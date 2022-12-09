@extends('teacher.basic.base_layout')

@section('title')
    <title>File Manager</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/css/teacher/file_manager.css">
@endsection

@section('pageContent')

<div class="col-md-12" style="padding: 0px">
    <div class="col-md-2" id="left-bar" style="padding: 0px">
        <div class="left-menu-item" id="upload-file"><span class="glyphicon glyphicon-cloud-upload"></span> Upload File</div>
        <div class="left-menu-item" id="new-folder"><span class="glyphicon glyphicon-plus"></span> New Folder</div>
        <div class="left-menu-item" id="upload-file"><span class="glyphicon glyphicon-trash"></span> Recycle Bin</div>
    </div>

    <div class="col-md-10" style="padding: 0px">
        <div class="col-md-12" style="padding: 0px">
            <div class="col-md-8">
                <p class="dir-file-heading text-center">File/Folder Name</p>
            </div>
            <div class="col-md-2">
                <p class="dir-file-heading text-center">File/Folder Type</p>
            </div>
            <div class="col-md-2">
                <p class="dir-file-heading text-center">File Size</p>
            </div>

            @for($i=0;$i<7;$i++)
                <?php
                $dir = rand(0,1);
                $fileIcons = [
                    'https://cdn1.iconfinder.com/data/icons/adobe-acrobat-pdf/154/adobe-acrobat-pdf-file-512.png',
                    'data:image/png;base64,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',
                    'https://cdn2.iconfinder.com/data/icons/line-files-type/129/TXT_File-512.png'
                ];
                $dirFileNames = [
                    'An agent that assists web browsing',
                    'detecting user interest',
                    'Machine Learning For User Modeling',
                    'Unsupervised and Supervised Machine Learning in User  Modeling',
                    'activity lifecycle'
                ];
                ?>
            <div class="col-md-12 dir-file-wrapper" style="padding: 0px">
                <div class="col-md-8">
                    <div class="directory">
                        <span class="glyphicon glyphicon-list"></span>
                        @if($dir)
                        <span class="glyphicon glyphicon-folder-open"></span>
                        @else
                        <span><img src="{{ $fileIcons[rand(0,2)] }}" width="25px" height="25px"></span>
                        @endif
                        <span class="dir-name">{{ $dirFileNames[rand(0,4)] }}</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <p class="dir-file-type text-center">{{ $dir? "Folder (2 files)":"File" }}</p>
                </div>
                <div class="col-md-2">
                    <p class="dir-file-size text-center">13.4 MB</p>
                </div>
            </div>
            @endfor
        </div>

        <div class="col-md-12">
            <iframe src="https://drive.google.com/embeddedfolderview?id=1dqR_znZsSmz5zwnrS9x9xlvaqhXo31a6#list" width="100%" height="700" frameborder="0"></iframe>
        </div>
    </div>
</div>


@endsection