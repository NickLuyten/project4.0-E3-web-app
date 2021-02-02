<?php

namespace App\Http\Controllers\Admin;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
            abort(403);
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
            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van de gebruikers.']);
        }


        $users = json_decode($usersresult->getBody())->results;

        return view('admin.users.index')->with('users', $users);
    }

    public function new_index(){
        return view('admin.users.create');
    }


    public function new(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'password' => 'required|string',
            'companyId' => 'required|integer',
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

        $guest = false;

        if($request->privileges == 2) {
            $permissions = "";

            for ($x = 1; $x <= 48; $x++) {

                if($request->$x != "") {
                    if($permissions == "") {
                        $permissions = "[\"".$request->$x."\"";
                    } else {
                        $permissions .= ",\"".$request->$x."\"";
                    }

                    echo($request->$x . "\n");
                }
            }
            $permissions .= "]";
        } elseif ($request->privileges == 1) {
            if($request->type == "lokale_admin") {
                $permissions = "[\"ALERT_CREATE_COMPANY\",\"ALERT_READ_COMPANY\",\"ALERT_DELETE_COMPANY\",\"AUTHENTICATION_CREATE_COMPANY\",\"AUTHENTICATION_READ_COMPANY\",\"AUTHENTICATION_UPDATE_COMPANY\",\"AUTHENTICATION_DELETE_COMPANY\",\"AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY\",\"AUTHERIZED_USER_PER_MACHINE_READ_COMPANY\",\"AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY\",\"COMPANY_UPDATE_COMPANY\",\"USER_CREATE_COMPANY\",\"USER_READ_COMPANY\",\"USER_UPDATE_COMPANY\",\"USER_DELETE_COMPANY\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY\",\"VENDING_MACHINE_CREATE_COMPANY\",\"VENDING_MACHINE_READ_COMPANY\",\"VENDING_MACHINE_UPDATE_COMPANY\",\"VENDING_MACHINE_DELETE_COMPANY\"]";
            } elseif($request->type == "admin") {
                $permissions = "[\"ALERT_CREATE\",\"ALERT_READ\",\"ALERT_DELETE\",\"AUTHENTICATION_CREATE\",\"AUTHENTICATION_READ\",\"AUTHENTICATION_UPDATE\",\"AUTHENTICATION_DELETE\",\"AUTHERIZED_USER_PER_MACHINE_CREATE\",\"AUTHERIZED_USER_PER_MACHINE_READ\",\"AUTHERIZED_USER_PER_MACHINE_DELETE\",\"COMPANY_CREATE\",\"COMPANY_READ\",\"COMPANY_UPDATE\",\"COMPANY_DELETE\",\"USER_CREATE\",\"USER_READ\",\"USER_UPDATE\",\"USER_DELETE\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE\",\"VENDING_MACHINE_CREATE\",\"VENDING_MACHINE_READ\",\"VENDING_MACHINE_UPDATE\",\"VENDING_MACHINE_DELETE\"]";
            }elseif($request->type == "gebruiker") {
                $permissions = "[\"AUTHENTICATION_CREATE_COMPANY_OWN\"]";
            }elseif($request->type == "guest") {
                $permissions = "[]";
                $guest= true;
            }

        }





    try {
        $result = $client->request('POST', '/api/user/register', [
            'headers' => $headers,
            'form_params' => [
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'companyId' => $request->input('companyId'),
                'sanitizerLimitPerMonth' => $request->input('sanitizerLimitPerMonth'),
                'admin' => $isAdmin,
                'guest' => $guest,
                'permissions' => $permissions,

            ]
        ]);
    } catch (RequestException $e) {
        return Redirect::back()->withErrors(['Er is iets misgelopen bij het aanmaken van de gebruiker.']);
    }
        return redirect('admin/users')->with('msg', 'De gebruiker '. $request->input('email')  .' succesvol aangemaakt.');
    }




    public function edit($id,Request $request)
    {
        $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken == ''){
            abort(403);
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

        $adminPermissions =["ALERT_CREATE",
            "ALERT_READ",
            "ALERT_DELETE",
            "AUTHENTICATION_CREATE",
            "AUTHENTICATION_READ",
            "AUTHENTICATION_UPDATE",
            "AUTHENTICATION_DELETE",
            "AUTHERIZED_USER_PER_MACHINE_CREATE",
            "AUTHERIZED_USER_PER_MACHINE_READ",
            "AUTHERIZED_USER_PER_MACHINE_DELETE",
            "COMPANY_CREATE",
            "COMPANY_READ",
            "COMPANY_UPDATE",
            "COMPANY_DELETE",
            "USER_CREATE",
            "USER_READ",
            "USER_UPDATE",
            "USER_DELETE",
            "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE",
            "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ",
            "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE",
            "VENDING_MACHINE_CREATE",
            "VENDING_MACHINE_READ",
            "VENDING_MACHINE_UPDATE",
            "VENDING_MACHINE_DELETE"] ;
        $lokale_adminPermissions =["ALERT_CREATE_COMPANY",
            "ALERT_READ_COMPANY",
            "ALERT_DELETE_COMPANY",
            "AUTHENTICATION_CREATE_COMPANY",
            "AUTHENTICATION_READ_COMPANY",
            "AUTHENTICATION_UPDATE_COMPANY",
            "AUTHENTICATION_DELETE_COMPANY",
            "AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY",
            "AUTHERIZED_USER_PER_MACHINE_READ_COMPANY",
            "AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY",
            "COMPANY_UPDATE_COMPANY",
            "USER_CREATE_COMPANY",
            "USER_READ_COMPANY",
            "USER_UPDATE_COMPANY",
            "USER_DELETE_COMPANY",
            "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY",
            "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY",
            "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY",
            "VENDING_MACHINE_CREATE_COMPANY",
            "VENDING_MACHINE_READ_COMPANY",
            "VENDING_MACHINE_UPDATE_COMPANY",
            "VENDING_MACHINE_DELETE_COMPANY"] ;
        $gebruikerPermissions = ["AUTHENTICATION_CREATE_COMPANY_OWN"];

        if($result->permissions == $adminPermissions){
            $admin = true;
            $lokale_admin = false;
            $gebruiker = false;
            $guest = false;
        } elseif ($result->permissions == $lokale_adminPermissions) {
            $admin = false;
            $lokale_admin = true;
            $gebruiker = false;
            $guest = false;
        }elseif ($result->permissions == $gebruikerPermissions) {
            $admin = false;
            $lokale_admin = false;
            $gebruiker = true;
            $guest = false;
        }else {
            $admin = false;
            $lokale_admin = false;
            $gebruiker = false;
            $guest = true;
        }

        $type = [
            'admin' => $admin,
            'lokale_admin' => $lokale_admin,
            'gebruiker' => $gebruiker,
            'guest' => $guest,

        ];

        return view('admin.users.edit')->with('user', $result)->with('type',$type);

//        return view('admin.users.edit')->with('user', $result);
    }


       public function update(Request $request, $id)
    {

        $request->validate([
            'email' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
        ]);


        $AuthToken = $request->cookie('AuthToken');

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

        if ($request->admin == 1) {
            $isAdmin = $request->admin = 1;
        } elseif ($request->admin != 1) {
            $isAdmin = $request->admin = 0;
        }
        $guest = false;

        if($request->privileges == 2) {
            $permissions = "";

            for ($x = 1; $x <= 48; $x++) {

                if($request->$x != "") {
                    if($permissions == "") {
                        $permissions = "[\"".$request->$x."\"";
                    } else {
                        $permissions .= ",\"".$request->$x."\"";
                    }

                    echo($request->$x . "\n");
                }
            }
            $permissions .= "]";
        } elseif ($request->privileges == 1) {
           if($request->type == "lokale_admin") {
               $permissions = "[\"ALERT_CREATE_COMPANY\",\"ALERT_READ_COMPANY\",\"ALERT_DELETE_COMPANY\",\"AUTHENTICATION_CREATE_COMPANY\",\"AUTHENTICATION_READ_COMPANY\",\"AUTHENTICATION_UPDATE_COMPANY\",\"AUTHENTICATION_DELETE_COMPANY\",\"AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY\",\"AUTHERIZED_USER_PER_MACHINE_READ_COMPANY\",\"AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY\",\"COMPANY_UPDATE_COMPANY\",\"USER_CREATE_COMPANY\",\"USER_READ_COMPANY\",\"USER_UPDATE_COMPANY\",\"USER_DELETE_COMPANY\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY\",\"VENDING_MACHINE_CREATE_COMPANY\",\"VENDING_MACHINE_READ_COMPANY\",\"VENDING_MACHINE_UPDATE_COMPANY\",\"VENDING_MACHINE_DELETE_COMPANY\"]";
            } elseif($request->type == "admin") {
               $permissions = "[\"ALERT_CREATE\",\"ALERT_READ\",\"ALERT_DELETE\",\"AUTHENTICATION_CREATE\",\"AUTHENTICATION_READ\",\"AUTHENTICATION_UPDATE\",\"AUTHENTICATION_DELETE\",\"AUTHERIZED_USER_PER_MACHINE_CREATE\",\"AUTHERIZED_USER_PER_MACHINE_READ\",\"AUTHERIZED_USER_PER_MACHINE_DELETE\",\"COMPANY_CREATE\",\"COMPANY_READ\",\"COMPANY_UPDATE\",\"COMPANY_DELETE\",\"USER_CREATE\",\"USER_READ\",\"USER_UPDATE\",\"USER_DELETE\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ\",\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE\",\"VENDING_MACHINE_CREATE\",\"VENDING_MACHINE_READ\",\"VENDING_MACHINE_UPDATE\",\"VENDING_MACHINE_DELETE\"]";
           }elseif($request->type == "gebruiker") {
               $permissions = "[\"AUTHENTICATION_CREATE_COMPANY_OWN\"]";
           }elseif($request->type == "guest") {
               $permissions = "[]";
               $guest= true;
           }

        }

    try {
        $result = $client->request('PUT', '/api/user/'.$id, [
            'headers' => $headers,
            'form_params' => [
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'sanitizerLimitPerMonth' => $request->input('sanitizerLimitPerMonth'),
                'admin' => $isAdmin,
                'guest' => $guest,
                'permissions' => $permissions,

            ]]);
    } catch (GuzzleException $e) {
        return Redirect::to('/admin/users')->withErrors('De gebruiker aanpassen is niet gelukt.');
    }
        return redirect('admin/users')->with('msg', 'De gebuiker '. $request->input('email')  .' succesvol aangepast.');
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
    try {
        $result = $client->request('DELETE', '/api/user/'.$id, [
            'headers' => $headers,

            ]);
    } catch (GuzzleException $e) {
        return Redirect::to('/admin/users')->withErrors('De gebruiker verwijderen is niet gelukt.');
    }
        return redirect('admin/users')->with('msg', 'De gebruiker succesvol verwijderd.');
    }

        public function qrcodeguest(Request $request,$id)
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
    try {
        $result = $client->request('POST', '/api/authentication/user', [
            'headers' => $headers,
            'form_params' => [
                'userId' => $id
            ]]);

    }catch (GuzzleException $e) {
        return Redirect::to('/admin/users')->withErrors('Qrcode is voor de guest aanmaken is niet gelukt.');
    }
        return redirect('admin/users')->with('msg', 'Qrcode is voor de guest aangemaakt.');
    }
}
