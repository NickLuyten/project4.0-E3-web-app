<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Json;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $sortList = [
            [
                'name'      => "Name (A => Z)",
                'column'    => 'name',
                'direction' => 'ASC'
            ],
            [
                'name'      => "Name (Z => A)",
                'column'    => 'name',
                'direction' => 'DESC'
            ],
            [
                'name'      => "Email (A => Z)",
                'column'    => 'email',
                'direction' => 'ASC'
            ],
            [
                'name'      => "Email (A => Z)",
                'column'    => 'email',
                'direction' => 'DESC'
            ],
            [
                'name'      => "Not Active",
                'column'    => 'active',
                'direction' => 'ASC'
            ],
            [
                'name'      => "Admin",
                'column'    => 'admin',
                'direction' => 'DESC'
            ]
        ];

        $listColumn = $sortList[$request->input('sort_by')]['column'] ?? 'name';
        $listDirection = $sortList[$request->input('sort_by')]['direction'] ?? 'asc';
        $user_name = '%' . $request->input('user_name') . '%';
        $users = User::orderBy($listColumn, $listDirection)
            ->where('name', 'like', $user_name)
            ->orWhere('email', 'like', $user_name)
            ->paginate(10)
            ->appends(['artist' => $request->input('user_name'), 'sort_by' => $request->input('sort_by')]);
        $result = compact('users','sortList');
        Json::dump($result);
        return view('admin.users.index', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $result = compact('user');
        Json::dump($result);
        return view('admin.users.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
       public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name' => 'required|min:3|unique:users,name,' . $user->id
        ]);
        $this->validate($request,[
            'email' => 'required|max:255|email|unique:users,email,' . $user->id
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->active == 1) {
            $user->active = 1;
        } else {
            $user->active = 0;
        }
        if ($request->admin == 1) {
            $user->admin = 1;
        } else {
            $user->admin = 0;
        }
        $user->save();
        session()->flash('success', "The user <b>$user->name</b> has been updated");
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        If ($user->id !== auth()->user()->id) {$user->delete();
            session()->flash('success', "The user <b>$user->name</b> has been deleted");}
        else { session()->flash('danger', "In order not to exclude yourself from (the admin section of) the application, you cannot delete your own profile");}

        return redirect('admin/users');
    }
}
