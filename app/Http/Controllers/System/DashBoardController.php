<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index()
    {
        return view('system.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form')->with('msg', 'Logout Successfully');
    }
}
