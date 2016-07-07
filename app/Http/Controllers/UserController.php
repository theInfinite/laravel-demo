<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('user');
    }

    public function addUser(Request $request){

        try {
            $user = new \App\User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
//
//            if($user->name == '' || $user->email || $user->password)
//                return 0;
            $user->save();
            return 'Success';
        }
        catch (Illuminate\Database\Exception $e){
            if($e->errorInfo[1] == 1062) {

                return 'already exist';
            }
//            $errorCode = $e->errorInfo[1];
            echo $e->getMessage();
        }
    }

    public function editUser(Request $request){

        $user = new \App\User();
        $name = trim($request->username);

        $userList = $user->where('email',$request->emailId)
                       ->update(array('name' =>$name ));

        return 'success';
    }

    public  function findList(Request $request){
        try {

            $user = \App\User::query();
            $user->where('name','like', '%'.$request->search_keyword.'%');
            $userList= $user->orderBy('created_at','DESC')->paginate(1);
            $content = "";

            if(count($userList)) {
                foreach ($userList as $user) {
                    $content .= "<tr>

                                    <td>
                                        $user->name
                                    </td>
                                    <td>
                                        $user->email
                                    </td>
                                    <td>
                                        <button type=\"button\" class=\"btn btn-success btn-xs fa fa-pencil\" data-toggle=\"modal\" data-target=\"#myModal$user->id\">&nbsp;Edit</button>
                                        <!-- Modal -->
                                        <div id=\"myModal$user->id\" class=\"modal fade\" role=\"dialog\">
                                            <div class=\"modal-dialog\">
                                                <!-- Modal content-->
                                                <div class=\"modal-content\">
                                                    <div class=\"modal-header\">
                                                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                                        <h4 class=\"modal-title\">Edit User</h4>
                                                    </div>
                                                    <div class=\"modal-body\">
                                                        <form class=\"form-horizontal\" id=\"addUserForm\" role=\"form\">
                                                            {{ csrf_field() }}


                                                            <div class=\"form-group\">
                                                            <label for=\"nameEdit\" class=\"col-md-4 control-label\">Name</label>

                                                            <div class=\"col-md-6\">
                                                                <input id=\"nameEdit$user->id\" type=\"text\" class=\"form-control\" name=\"nameEdit\" value=\"$user->name\">
                                                           </div>
                                                            </div>
                                                            <div class=\"form-group\">
                                                                <label for=\"emailEdit\" class=\"col-md-4 control-label\">Email</label>

                                                                <div class=\"col-md-6\">
                                                                    <input id=\"emailEdit$user->id\" type=\"text\" class=\"form-control\" name=\"emailEdit\" value=\"$user->email\">
                                                                </div>
                                                            </div>
                                                            <div class=\"form-group\">
                                                                <label for=\"pwdEdit\" class=\"col-md-4 control-label\">Password</label>

                                                                <div class=\"col-md-6\">
                                                                    <input id=\"pwdEdit$user->id\" type=\"password\" class=\"form-control\" name=\"pwdEdit\" value=\"$user->password\">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class=\"modal-footer\">
                                                        <button type=\"button\" class=\"btn btn-default btn-success\" onclick=\"editUser('$user->email','$user->id')\"  data-dismiss=\"modal\">Update</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <button type=\"button\" class=\"btn btn-danger btn-xs fa fa-trash-o\" onclick=\"deleteUser('$user->email')\"> Delete</button>
                                    </td>
                                </tr>";
                }
            }else {
                $content .= "<tr>
                                <td colspan=\"3\">

                                    <div align=\"center\"><h3>No Record Found.</h3>
                                    </div>
                                </td>
                             </tr>";
            }

            $data = new \stdClass();
            $data->content = $content;

            ob_start();
             echo $userList->render();
            $pagination = ob_get_contents();
            ob_flush();

            $data->pagination = $pagination;

            die(json_encode($data));

        }
        catch (Illuminate\Database\Exception $e){
            if($e->errorInfo[1] == 1062) {

                echo 'Error';
            }
//            $errorCode = $e->errorInfo[1];
            echo $e->getMessage();
        }

    }

    public function deleteUser(Request $request){

            //dd($request->emailId);
            $user = new \App\User();

            $user->where('email',$request->emailId)->delete();

            $userList = $user->get();
            //dd($userList);
            $content = "";

            if(count($userList)) {
                foreach ($userList as $user) {
                    $content .= "<tr>
                                    <td>
                                        $user->name
                                    </td>
                                    <td>
                                        $user->email
                                    </td>
                                    <td>
                                        <button type=\"button\" class=\"btn btn-success btn-xs fa fa-pencil\" data-toggle=\"modal\" data-target=\"#myModal$user->id\">&nbsp;Edit</button>
                                        <!-- Modal -->
                                        <div id=\"myModal$user->id\" class=\"modal fade\" role=\"dialog\">
                                            <div class=\"modal-dialog\">
                                                <!-- Modal content-->
                                                <div class=\"modal-content\">
                                                    <div class=\"modal-header\">
                                                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                                        <h4 class=\"modal-title\">Edit User</h4>
                                                    </div>
                                                    <div class=\"modal-body\">
                                                        <form class=\"form-horizontal\" id=\"addUserForm\" role=\"form\">
                                                            {{ csrf_field() }}


                                                            <div class=\"form-group\">
                                                            <label for=\"nameEdit\" class=\"col-md-4 control-label\">Name</label>

                                                            <div class=\"col-md-6\">
                                                                <input id=\"nameEdit$user->id\" type=\"text\" class=\"form-control\" name=\"nameEdit\" value=\"$user->name\">
                                                           </div>
                                                            </div>
                                                            <div class=\"form-group\">
                                                                <label for=\"emailEdit\" class=\"col-md-4 control-label\">Email</label>

                                                                <div class=\"col-md-6\">
                                                                    <input id=\"emailEdit$user->id\" type=\"text\" class=\"form-control\" name=\"emailEdit\" value=\"$user->email\">
                                                                </div>
                                                            </div>
                                                            <div class=\"form-group\">
                                                                <label for=\"pwdEdit\" class=\"col-md-4 control-label\">Password</label>

                                                                <div class=\"col-md-6\">
                                                                    <input id=\"pwdEdit$user->id\" type=\"password\" class=\"form-control\" name=\"pwdEdit\" value=\"$user->password\">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class=\"modal-footer\">
                                                        <button type=\"button\" class=\"btn btn-default btn-success\" onclick=\"editUser('$user->email','$user->id')\"  data-dismiss=\"modal\">Update</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <button type=\"button\" class=\"btn btn-danger btn-xs fa fa-trash-o\" onclick=\"deleteUser('$user->email')\"> Delete</button>
                                    </td>
                                </tr>";
                }
            }else {
                $content .= "<tr>
                                <td colspan=\"3\">

                                    <div align=\"center\"><h3>No Record Found.</h3>
                                    </div>
                                </td>
                             </tr>";
            }

            echo $content;

    }
}
