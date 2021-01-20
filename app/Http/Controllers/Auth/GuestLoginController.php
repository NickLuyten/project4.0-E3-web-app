<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuestLoginController extends Controller
{
    public function show()
    {
        return view('auth/guestlogin');
    }
}
