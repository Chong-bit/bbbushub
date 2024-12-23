<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('dashboard');
    }

    public function route(){
        return view('route');
    }

    public function report(){
        return view('report');
    }
}
