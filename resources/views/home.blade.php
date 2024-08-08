@extends('layouts.user')

@section('content')
<div class="table-title">
    <div class="row">
        <div class="col-sm-6">
            <h2>User <b>List</b></h2>
        </div>
        <div class="col-sm-6">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fa fa-plus-circle"></i><span>Add New User</span></button>
        </div>
    </div>
</div>

<table class="table table-responsive table-striped2 table-hover">
    <thead>
        <tr>
            <th>S. No.</th>
            <th>Profile Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Description</th>
            <th>Role ID</th>
        </tr>
    </thead>
    <tbody class="userRecord"></tbody>
</table>

<div class="modal" id="addUserModal">
    <div class="modal-dialog">
        <form id="user-form" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-2">
                                <label>Name</label>
                                <input type="text" class="form-control name" name="name">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group m-2">
                                <label>Email</label>
                                <input type="text" class="form-control email" name="email">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group m-2">
                                <label>Phone</label>
                                <input type="text" class="form-control phone" name="phone">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group m-2">
                                <label>Description</label>
                                <textarea class="form-control description" name="description"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group m-2">
                                <label>Role ID</label>
                                <select class="form-control role_id" name="role_id">
                                    @if(count($roleList) > 0)
                                        @foreach($roleList as $key=>$roleRow)
                                            <option value="{{$key}}">{{$roleRow}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group m-2">
                                <label>Profile Image</label>
                                <input type="file" class="form-control profile" name="profile" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="justify-content: center;">
                    <input type="submit" class="btn btn-info text-white submitUser" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
        userList();

        $(document).on("submit", "#user-form", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{ route("create-user") }}',
                data : formData,
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                            title: data.message,
                            icon: "error",
                            showConfirmButton: true,
                            timer: 2000,
                            confirmButtonColor: "#0199B8"
                    });
                    $('.btn-close').click();
                    $('#user-form')[0].reset();
                    $(".commonErr").remove();
                    userList();
                },
                error:function (response){
                    $(".commonErr").remove();
                    $.each(response.responseJSON.errors,function(field_name,error){
                        $(document).find('.'+field_name+'').after('<span class="text-strong text-danger commonErr">' +error+ '</span>');
                    })
                },
                contentType: false,
                processData: false
            });
        });
    });
    function userList(){
        $.ajax({
            type: 'GET',
            url: '{{ route("user-list") }}',
            dataType: 'html',
            success: function(data) {
                $('.userRecord').empty();
                $('.userRecord').append(data);
            }
        });
    }
</script>
@endsection
