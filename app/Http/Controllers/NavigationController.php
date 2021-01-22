<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;

class NavigationController extends Controller
{
    public function home(Request $request){
        $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken != ''){
            return Redirect::to('dashboard');
        } else {
            return view('home');
        }
    }
}
