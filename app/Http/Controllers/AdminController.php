<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //echo "here";exit;
        return view('adminpanel/dashboard');
    }

    /**
     * Show the application login.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login()
    {
      return view('adminpanel/login');
    }

    // public function logout(Request $request)
    // {
    //   Auth::logout();
    //
    //   $request->session()->invalidate();
    //
    //   $request->session()->regenerateToken();
    //
    //   return redirect('/');
    // }

}
