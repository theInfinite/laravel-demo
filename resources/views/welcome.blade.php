@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

                <div >

                    <div class="col-sm-4 m-b-xs">
                        <form class="form-horizontal" role="form">
                            {{ csrf_field() }}

                            <input type="text" class="form-control" id="search_keyword" name = "search_keyword"
                               maxlength="30"
                               placeholder="Search by user name"/>
                        </form>
                    </div>

                    <div class="col-sm-2 m-b-xs pull-right nav navbar-nav">

                        <a class="fa fa-users" href="{{ url('/user') }}">&nbsp;&nbsp;&nbsp;&nbsp;Add New User</a>

                        <div class="pull-right box-header" data-original-title="">
<!--                            --><?php //echo $users->peginate(request()->only('name','email'))->render(); ?>
                        </div>
                    </div>

                    <div class="col-md-12 table-responsive" style="margin-top: 20px">
                        <table class="table table-striped">
                            <colgroup>
                                <col width="20%"/>
                                <col width="60%"/>
                                <col width="20%"/>
                            </colgroup>
                            <thead>
                            <tr id="UserListheading">
                                <th>User Name
                                </th>
                                <th>Email
                                </th>
                                <th>Action
                                </th>
                            </tr> </thead>
                            <div id="loader" style="display: none;" class="col-md-7 col-md-offset-5 span3">
                                <img style="width: 200px !important; height: 200px !important;" class="group1" src="image/loading.gif" title="Click to Zoom" />
                            </div>
                            <tbody id="userListing">
                            @if($users)
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        {{$user->name}}
                                    </td>
                                    <td>
                                        {{$user->email}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-xs fa fa-pencil" data-toggle="modal" data-target="#myModal{{$user->id}}">&nbsp;Edit</button>
                                        <!-- Modal -->
                                        <div id="myModal{{$user->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Edit User</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" id="addUserForm" role="form">
                                                            {{ csrf_field() }}


                                                            <div class="form-group">
                                                            <label for="nameEdit" class="col-md-4 control-label">Name</label>

                                                            <div class="col-md-6">
                                                                <input id="nameEdit{{$user->id}}" type="text" class="form-control" name="nameEdit" value="{{ $user->name }}">
                                                           </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="emailEdit" class="col-md-4 control-label">Email</label>

                                                                <div class="col-md-6">
                                                                    <input id="emailEdit{{$user->id}}" type="text" class="form-control" name="emailEdit" value="{{ $user->email }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="pwdEdit" class="col-md-4 control-label">Password</label>

                                                                <div class="col-md-6">
                                                                    <input id="pwdEdit{{$user->id}}" type="password" class="form-control" name="pwdEdit" value="{{ $user->password }}">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default btn-success" onclick="editUser('{{$user->email}}','{{$user->id}}')"  data-dismiss="modal">Update</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-danger btn-xs fa fa-trash-o" onclick="deleteUser('{{$user->email}}')"> Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">

                                        <div align="center"><h3>No Record Found.</h3>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            <div id="pagination" class="pull-right">
                                <?php echo $users->render(); ?>
                            </div>
                            </tbody>
                        </table>
                    </div>

                </div>
        </div>
    </div>
</div>
@endsection
