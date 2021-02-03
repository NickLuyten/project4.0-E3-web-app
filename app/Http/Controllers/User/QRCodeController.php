<?php

namespace App\Http\Controllers\User;

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
        if ($AuthToken == ''){
            return Redirect::to('/login');
        }

        $client = new Client([
            'base_uri' => $this->db,
            'timeout'  => 2.0,
        ]);
        try {
            if($request->cookie('guest') ==false) {
                $headers = [
                    'Authorization' => 'Bearer ' . $AuthToken
                ];

                $hashresult = $client->request('POST', '/api/authentication/', [
                    'headers' => $headers
                ]);
            } else {
                $id = $request->cookie('userId');
                $headers = [
                    'Authorization' => 'Bearer ' . $AuthToken
                ];

                $hashresult = $client->request('GET', '/api/authentication/user/'.$id, [
                    'headers' => $headers
                ]);
            }

        }

        catch (RequestException $e) {
            return Redirect::back()->withErrors(['Er is iets fout gelopen met het aanvragen van je QR code.']);
        }


        $hash = json_decode($hashresult->getBody())->result->authentication;

        return view('QRcode')->with('hash', $hash);
    }
}
