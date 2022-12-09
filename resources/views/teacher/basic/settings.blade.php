@extends('teacher/basic/base_layout')

@section('title')
    <title>Setings</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/css/teacher/settings.css">
@endsection

@section('pageContent')
    <div class="col-md-12 text-center" id="">
        <div class="col-md-8 col-md-offset-2 joint-token-wrapper">
            <h2>Join Department</h2>
            <p class="auth-code">Authentication code : <span class="join-token">{{ $joinToken }}</span></p>
            <span class="font-color-1">This code is required to join your department</span>
        </div>

        <div class="col-md-8 col-md-offset-2 pp-upload-wrapper text-center">
            <h2>Upload a photo</h2>
            <div class="col-md-3">
                <img src="{{ $profilePicUrl or "" }}" alt="" class="img-responsive pp">
            </div>
            <div class="col-md-9 text-center">
                <form action="/settings/upload_photo" method="post" enctype="multipart/form-data" style="margin-top: 3em">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <input type="file" name="pp" required>
                    </div>
                    <div class="col-md-6">
                        <input type="submit" value="Upload Photo" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection