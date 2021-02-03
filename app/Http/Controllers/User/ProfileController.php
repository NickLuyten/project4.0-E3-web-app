<?php

namespace App\Http\Controllers\User;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    // Edit user profile
    public function edit(Request $request)
    {
        $AuthToken = $request->cookie('AuthToken');
        $id = $request->cookie('userId');
        if ($AuthToken == ''){
            abort(403);
        }

        $client = new Client([
            'base_uri' => $this->db,
            'timeout'  => 2.0,
        ]);
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $AuthToken
            ];

            $userresult = $client->request('GET', '/api/user/'.$id, [
                'headers' => $headers
            ]);
        }

        catch (RequestException $e) {
            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van je gegevens.']);
        }


        $result = json_decode($userresult->getBody())->result;



        return view('user.profile')->with('user', $result);

    }

    // Update user profile
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
        ]);


        $AuthToken = $request->cookie('AuthToken');
        $id = $request->cookie('userId');
        if ($AuthToken == ''){
            abort(403);
        }

        $client = new Client([
            'base_uri' => $this->db,
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];



        try {
            $result = $client->request('PUT', '/api/user/'.$id, [
                'headers' => $headers,
                'form_params' => [
                    'firstName' => $request->input('firstName'),
                    'lastName' => $request->input('lastName'),
                    'email' => $request->input('email'),


                ]]);
        } catch (GuzzleException $e) {
            return Redirect::to('/dashboard')->withErrors('het aanpassen van je profiel is mislukt.');
        }
        return redirect('/dashboard')->with('msg', 'Je profiel is aangepast.');
    }
}
