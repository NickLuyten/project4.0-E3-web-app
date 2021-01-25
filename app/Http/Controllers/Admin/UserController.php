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
//        try {
            $headers = [
                'Authorization' => 'Bearer ' . $AuthToken
            ];

            $usersresult = $client->request('GET', '/api/user/all/', [
                'headers' => $headers
            ]);
//        }
//
//        catch (RequestException $e) {
//            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van de users.']);
//        }


        $users = json_decode($usersresult->getBody())->results;

        return view('admin.users.index')->with('users', $users);
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//       //
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\User  $user
//     * @return \Illuminate\Http\Response
//     */
//    public function show(User $user)
//    {
//        return redirect('admin/users');
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\User  $user
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(User $user)
//    {
//        $result = compact('user');
//        Json::dump($result);
//        return view('admin.users.edit', $result);
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\User  $user
//     * @return \Illuminate\Http\Response
//     */
//       public function update(Request $request, User $user)
//    {
//        $this->validate($request,[
//            'name' => 'required|min:3|unique:users,name,' . $user->id
//        ]);
//        $this->validate($request,[
//            'email' => 'required|max:255|email|unique:users,email,' . $user->id
//        ]);
//        $user->name = $request->name;
//        $user->email = $request->email;
//        if ($request->active == 1) {
//            $user->active = 1;
//        } else {
//            $user->active = 0;
//        }
//        if ($request->admin == 1) {
//            $user->admin = 1;
//        } else {
//            $user->admin = 0;
//        }
//        $user->save();
//        session()->flash('success', "The user <b>$user->name</b> has been updated");
//        return redirect('admin/users');
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\User  $user
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(User $user)
//    {
//        //
//        If ($user->id !== auth()->user()->id) {$user->delete();
//            session()->flash('success', "The user <b>$user->name</b> has been deleted");}
//        else { session()->flash('danger', "In order not to exclude yourself from (the admin section of) the application, you cannot delete your own profile");}
//
//        return redirect('admin/users');
//    }
}
