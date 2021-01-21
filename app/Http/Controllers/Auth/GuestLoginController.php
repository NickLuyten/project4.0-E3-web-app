<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//composer require guzzlehttp/guzzle
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Redirect;

class GuestLoginController extends Controller
{
    public function show()
    {
        return view('auth/guestlogin');
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
