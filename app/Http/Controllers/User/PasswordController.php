<?php

namespace App\Http\Controllers\User;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    // Edit user password
    public function edit()
    {
        return view('user.password');
    }

    // Update and encrypt user password
    public function update(Request $request)
    {
        // Validate $request
        $this->validate($request, [
            'newPassword' => 'required',
            'newPasswordConfirm' => 'required',
        ]);

        if ($request->input('newPassword') == $request->input('newPasswordConfirm')) {
            $password = $request->input('newPassword');

            $AuthToken = $request->cookie('AuthToken');
            $id = $request->cookie('userId');
            if ($AuthToken == ''){
                abort(403);
            }

            $client = new Client([
                'base_uri' => 'https://project4-restserver.herokuapp.com',
                'timeout'  => 2.0,
            ]);
            $headers = [
                'Authorization' => 'Bearer ' . $AuthToken
            ];



            try {
                $result = $client->request('PUT', '/api/user/'.$id, [
                    'headers' => $headers,
                    'form_params' => [
                        'password' => $password


                    ]]);
            } catch (GuzzleException $e) {
                return Redirect::to('/dashboard')->withErrors('het aanpassen van je watchtwoord is mislukt.');
            }


            return redirect('/dashboard')->with('msg', 'Je watchtwoord is aangepast.');
        } else {
            session()->flash('danger', "De 2 wachtwoorden komen niet overeen");
            return back();
        }


    }
}
