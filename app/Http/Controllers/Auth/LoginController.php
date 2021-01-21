<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Redirect;
use Illuminate\Validation\ValidationException;
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

        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);


        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);

        try {

        $result = $client->request('POST', '/api/user/authenticate', [
            'form_params' => [
                'email' => $request->input('email'),
                "password" => $request->input('password')
            ]
        ]);

            $resultJson = json_decode($result->getBody())->result;
            $token = $resultJson->accessToken;

            $headers = [
                'Authorization' => 'Bearer ' . $token
            ];

            $hashresult = $client->request('POST', '/api/authentication/', [
                'headers' => $headers
            ]);

            $hash = json_decode($hashresult->getBody())->result->authentication;
            Cookie::queue('AuthToken', $token, 60);
            return view('QRcode')->with('hash', $hash);
        }
        catch (RequestException $e) {
            return Redirect::back()->withErrors('msg', 'Er is iets fout gelopen met het inloggen. Gelieve uw gegevens te controleren.');
        }

    }

}
