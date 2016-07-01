@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div>


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
                            <tr>
                                <th>User Name
                                </th>
                                <th>Email
                                </th>
                                <th>Action
                                </th>
                            </tr> </thead>
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
                                        <button type="button" class="btn btn-success btn-xs fa fa-edit" onclick="editUser('{{$user->email}}')"> Edit</button>
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
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
