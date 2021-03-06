<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class HomeController extends Controller
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
        return view('home');
    }

    public function showList(){

        $user = new \App\User();
        $userList = $user->orderBy('created_at','DESC')->paginate(5);

            return view('welcome',['users'=>$userList]);
    }
}
