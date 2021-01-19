<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('home');
    }
}
// Get the currently authenticated user
$user = auth()->user();             // or Auth::user();
Json::dump($user);

// Get one attribute off the currently authenticated user's (e.g. name, email, id, ...)
$name = auth()->user()->name;       // or Auth::user()->name;
Json::dump($name);

// Shortcut for the currently authenticated user's id
$id = auth()->id();                 // or Auth::id();
Json::dump($id);