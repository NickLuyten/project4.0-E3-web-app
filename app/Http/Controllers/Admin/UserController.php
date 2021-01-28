<?php

namespace App\Http\Controllers\Admin;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Json;
use Redirect;

class UserController extends Controller
{

    public function index(Request $request)
    {
//        $sortList = [
//            [
//                'name'      => "Name (A => Z)",
//                'column'    => 'name',
//                'direction' => 'ASC'
//            ],
//            [
//                'name'      => "Name (Z => A)",
//                'column'    => 'name',
//                'direction' => 'DESC'
//            ],
//            [
//                'name'      => "Email (A => Z)",
//                'column'    => 'email',
//                'direction' => 'ASC'
//            ],
//            [
//                'name'      => "Email (A => Z)",
//                'column'    => 'email',
//                'direction' => 'DESC'
//            ],
//            [
//                'name'      => "Not Active",
//                'column'    => 'active',
//                'direction' => 'ASC'
//            ],
//            [
//                'name'      => "Admin",
//                'column'    => 'admin',
//                'direction' => 'DESC'
//            ]
//        ];

         $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken == ''){
            return Redirect::to('/login');
        }

        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $AuthToken
            ];

            $usersresult = $client->request('GET', '/api/user/all/', [
                'headers' => $headers
            ]);
        }

        catch (RequestException $e) {
            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van de users.']);
        }


        $users = json_decode($usersresult->getBody())->results;

        return view('admin.users.index')->with('users', $users);
    }


    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
        ]);


        $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken == ''){                                                                          //permissiecheck toevoegen, of in route
            abort(403);
        }

        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];

        if ($request->admin == 1) {
            $isAdmin = $request->admin = 1;
        } elseif ($request->admin != 1) {
            $isAdmin = $request->admin = 0;
        }

        $result = $client->request('POST', '/api/user/register', [
            'headers' => $headers,
            'form_params' => [
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'admin' => $isAdmin,

            ]
        ]);


        return view(admin/users/create);
    }




    public function edit($id,Request $request)
    {
        $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken == ''){
            return Redirect::to('/login');
        }

        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
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
            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van de user.']);
        }


        $result = json_decode($userresult->getBody())->result;

        return view('admin.users.edit')->with('user', $result);
    }


       public function update(Request $request, $id)
    {

        $request->validate([
            'email' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
        ]);


        $AuthToken = $request->cookie('AuthToken');

        if ($AuthToken == ''){                                                                          //permissiecheck toevoegen, of in route
            abort(403);
        }

        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];

        if ($request->admin == 1) {
            $isAdmin = $request->admin = 1;
        } elseif ($request->admin != 1) {
            $isAdmin = $request->admin = 0;
        }

//
//        $permissions = "[";
//        for ($x = 1; $x <= 48; $x++) {
//            if($request->permissions != "")
//
//                $permissions += $request->permissions;
//        }


        $result = $client->request('PUT', '/api/user/'.$id, [
            'headers' => $headers,
            'form_params' => [
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'admin' => $isAdmin,
//                'permissions' => $permissions,

            ]]);
        return redirect('admin/id/users');
    }

    public function destroy(Request $request,$id)
    {
        //
        $AuthToken = $request->cookie('AuthToken');

        if ($AuthToken == ''){                                                                          //permissiecheck toevoegen, of in route
            abort(403);
        }

        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];

        $result = $client->request('DELETE', '/api/user/'.$id, [
            'headers' => $headers,

            ]);


        return redirect('admin/id/users');
    }
}
