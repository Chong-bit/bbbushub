<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function bus(){
        return view('admin.bus');
    }

    public function location(){
        return view('admin.location');
    }

    public function route(){
        return view('admin.route');
    }

    public function status(){
        return view('admin.status');
    }
}
