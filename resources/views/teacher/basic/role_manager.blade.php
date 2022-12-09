@extends('teacher/basic/base_layout')

@section('title')
    <title>Role Management Panel</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/css/teacher/role_manager.css">
@endsection

@section('pageContent')
    <div class="col-md-12" style="padding: 0">
        <h2 class="text-center">Role Management Panel</h2>
        <section class="col-md-10 col-md-offset-1" id="role-manager-wrapper">
            <div class="col-md-12 row" style="padding: 0">
                @foreach($userInfo as $user)
                <div class="col-md-6" style="">
                    <div class="single-user-wrapper col-md-12">
                        <div class="col-md-3">
                            <img src="/images/habibur.jpg" alt="image" class="pp img-responsive">
                        </div>
                        <div class="name col-md-9" style="padding: 0">{{ $user->name }}</div>
                        <p class="role-update-msg" id="role-update-msg{{ $user->user_id }}">Role updated successfully !</p>
                        <div class="email col-md-9" style="padding: 0">
                            <span class="glyphicon glyphicon-envelope"></span>
                            {{ $user->email }}
                        </div>
                        <div class="col-md-9" style="padding: 0">
                            <div class="col-md-2" style="padding: 0; font-size: 1.4em">Role:</div>
                            <div class="role-wrapper col-md-10" style="padding: 0">
                                <select name="" id="role-dropdown-{{ $user->user_id }}" class="form-control" data-user-id="{{ $user->user_id }}">
                                    @foreach($roles as $roleName => $roleId)
                                        <option value="{{ $roleId }}" {{ $roleId == $user->role_id ? 'selected':'' }}>{{ $roleName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="join-time col-md-9" style="padding: 0">
                            Joined : {{ (\Carbon\Carbon::parse($user->created_at))->diffForHumans() }}
                            <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y , h:i:s') }}"></span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('.role-wrapper select').on('change', function () {
                var userId = $(this).attr('data-user-id');
                var roleId = $(this).val();
                var roleText = $('#role-dropdown-'+userId+' option:selected').text();
                if(confirm("Set role to "+roleText+" ?")){
                    $.ajax({
                        url : '/roles/teacher/update_role',
                        type : 'post',
                        data : {
                            _token : "{{ csrf_token() }}", user_id : userId, role_id : roleId
                        },success : function (response) {
                            console.log(response);
                            $('#role-update-msg'+userId).animate({
                                top : '0px',
                                opacity : 1
                            }).delay(3000).animate({
                                top : '-500%',
                                opacity : 0
                            });

                        }, error : function (a, b, c) {
                            alert("Error occurred. Try again");
                        }
                    });
                }
            });
        });
    </script>
@endsection
