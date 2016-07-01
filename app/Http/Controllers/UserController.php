<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use DB;

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


    public  function findList(Request $request){
        try {

            $user = \App\User::query();
            $user->where('name','like', '%'.$request->search_keyword.'%');
//            $user->orderBy('created_at','DESC')->paginate(5);
            $userList = $user->get();
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
                                    <button type=\"button\" class=\"btn btn-success btn-xs fa fa-edit\" onclick=\"editUser('{{$user->email}}')\"> Edit</button>
                                    <button type=\"button\" class=\"btn btn-danger btn-xs fa fa-trash-o\" onclick=\"deleteUser('{{$user->email}}')\"> Delete</button>
                                </td>
                            </tr>";
                }
            }else {
                $content .= "<tr>
                                <td colspan=\"6\">

                                        <div align=\"center\"><h3>No Record Found.</h3>
                                        </div>
                                    </td>
                            </tr>";
            }

            echo $content;

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

            dd($request->emailId);
            $user = new \App\User();

            $user->delete();
            return 'Success';
    }
}
