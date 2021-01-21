<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users2 for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

//    use AuthenticatesUsers;
//
//    /**
//     * Where to redirect users2 after login.
//     *
//     * @var string
//     */
//    protected $redirectTo = '/';
//
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//    }

    public function show()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);

        $result = $client->request('GET', '/api/user/all', [
            'form_params' => [
                'firstName', $request->name,
                'lastName', $request->lastname,
                'email', $request->email,
                "password",$request->password,

            ]

        ]);

        error_log($result);

        return view('/home');
    }

    public function request(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);



        $result = $client->request('POST', '/api/user/register', [
            'form_params' => [
                'firstName', $request->name,
                'lastName', $request->lastname,
                'email', $request->email,
            ]
        ]);

        if ($result->getStatusCode() == 200){
            return view('QRcode', $result);
        }
        else {
            return Redirect::back()->withErrors('msg', 'Er is iets fout gelopen met het registreren. Gelieve een andere keer opnieuw te proberen.');
        }


    }
}
