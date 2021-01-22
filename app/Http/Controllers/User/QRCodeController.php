<?php

namespace App\Http\Controllers\user;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Redirect;

class QRCodeController extends Controller
{
    public function request(Request $request)
    {
        $AuthToken = $request->cookie('AuthToken');

        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $AuthToken
            ];

            $hashresult = $client->request('POST', '/api/authentication/', [
                'headers' => $headers
            ]);
        }

        catch (RequestException $e) {
            return Redirect::back()->withErrors(['Er is iets fout gelopen met het aanvragen van je QR code.']);
        }


        $hash = json_decode($hashresult->getBody())->result->authentication;

        return view('QRcode')->with('hash', $hash);
    }
}
