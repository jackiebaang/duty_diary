<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $userName = Auth::user()->name;
            $userRole = Auth::user()->role_id;
            $userImg = Auth::user()->img;
            $userSign = Auth::user()->sign;
            
            Session::put('USERNAME', $userName);
            Session::put('USERROLE', $userRole);
            Session::put('USERIMG', $userImg);
            Session::put('USERSIGN', $userSign);
        }
        return view('admin.dashboard');
    }
}
