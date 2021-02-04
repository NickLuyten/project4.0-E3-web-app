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


        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('USER_READ', $Permissions) or in_array('USER_READ_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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

            $usersresult = $client->request('GET', '/api/user/all/', [
                'headers' => $headers
            ]);

            $typesresult = $client->request('GET', '/api/type/all/', [
                'headers' => $headers
            ]);

            $companiesresult = $client->request('GET', '/api/company/all/', [
                'headers' => $headers
            ]);
        }

        catch (RequestException $e) {
            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van de gebruikers.']);
        }


        $users = json_decode($usersresult->getBody())->results;
        $types = json_decode($typesresult->getBody())->results;
        $companies = json_decode($companiesresult->getBody())->results;

        return view('admin.users.index')->with('users', $users)->with('types', $types)->with('companies', $companies);
    }

    public function new_index(Request $request){

        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('USER_CREATE', $Permissions) or in_array('USER_CREATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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

            $typesresult = $client->request('GET', '/api/type/all/', [
                'headers' => $headers
            ]);
            $companiesresult = $client->request('GET', '/api/company/all/', [
                'headers' => $headers
            ]);
        }catch (RequestException $e) {
            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van de gegevens.']);
        }

        $types = json_decode($typesresult->getBody())->results;
        $companies = json_decode($companiesresult->getBody())->results;
        return view('admin.users.create')->with('types', $types)->with('companies', $companies);
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
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('USER_CREATE', $Permissions) or in_array('USER_CREATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
            abort(403);
        }

        $client = new Client([
            'base_uri' => $this->db,
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];


        $admin = false;
        $guest = false;

//        if($request->privileges == 2) {
//            $permissions = "";
//
//            for ($x = 1; $x <= 48; $x++) {
//
//                if($request->$x != "") {
//                    if($permissions == "") {
//                        $permissions = "[\"".$request->$x."\"";
//                    } else {
//                        $permissions .= ",\"".$request->$x."\"";
//                    }
//
//                    echo($request->$x . "\n");
//                }
//            }
//            $permissions .= "]";
//        } elseif ($request->privileges == 1) {
            if($request->type == "lokale_admin") {
                $admin = true;
                $permissions = "[\"ALERT_CREATE_COMPANY\",
    \"ALERT_READ_COMPANY\",
    \"ALERT_DELETE_COMPANY\",
    \"AUTHENTICATION_CREATE_COMPANY\",
    \"AUTHENTICATION_READ_COMPANY\",
    \"AUTHENTICATION_UPDATE_COMPANY\",
    \"AUTHENTICATION_DELETE_COMPANY\",
    \"AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY\",
    \"AUTHERIZED_USER_PER_MACHINE_READ_COMPANY\",
    \"AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY\",
    \"COMPANY_UPDATE_COMPANY\",
    \"USER_CREATE_COMPANY\",
    \"USER_READ_COMPANY\",
    \"USER_UPDATE_COMPANY\",
    \"USER_DELETE_COMPANY\",
    \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY\",
    \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY\",
    \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY\",
    \"VENDING_MACHINE_CREATE_COMPANY\",
    \"VENDING_MACHINE_READ_COMPANY\",
    \"VENDING_MACHINE_UPDATE_COMPANY\",
    \"VENDING_MACHINE_DELETE_COMPANY\",
    \"TYPE_CREATE_COMPANY\",
    \"TYPE_READ_COMPANY\",
    \"TYPE_UPDATE_COMPANY\",
    \"TYPE_DELETE_COMPANY\"]";
            } elseif($request->type == "admin") {
                $admin = true;
                $permissions = "[
            \"ALERT_CREATE\",
            \"ALERT_READ\",
            \"ALERT_DELETE\",
            \"AUTHENTICATION_CREATE\",
            \"AUTHENTICATION_READ\",
            \"AUTHENTICATION_UPDATE\",
            \"AUTHENTICATION_DELETE\",
            \"AUTHERIZED_USER_PER_MACHINE_CREATE\",
            \"AUTHERIZED_USER_PER_MACHINE_READ\",
            \"AUTHERIZED_USER_PER_MACHINE_DELETE\",
            \"COMPANY_CREATE\",
            \"COMPANY_READ\",
            \"COMPANY_UPDATE\",
            \"COMPANY_DELETE\",
            \"USER_CREATE\",
            \"USER_READ\",
            \"USER_UPDATE\",
            \"USER_DELETE\",
            \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE\",
            \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ\",
            \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE\",
            \"VENDING_MACHINE_CREATE\",
            \"VENDING_MACHINE_READ\",
            \"VENDING_MACHINE_UPDATE\",
            \"VENDING_MACHINE_DELETE\",
            \"TYPE_CREATE\",
            \"TYPE_READ\",
            \"TYPE_UPDATE\",
            \"TYPE_DELETE\"
        ]";
            }elseif($request->type == "gebruiker") {
                $permissions = "[\"AUTHENTICATION_CREATE_COMPANY_OWN\"]";
            }elseif($request->type == "guest") {
                $permissions = "[]";
                $guest= true;
            }

//        }





    try {
        $result = $client->request('POST', '/api/user/register', [
            'headers' => $headers,
            'form_params' => [
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'companyId' => $request->input('companyId'),
                'typeId' => $request->input('typeFunctie'),
                'admin' => $admin,
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
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('USER_UPDATE', $Permissions) or in_array('USER_UPDATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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

            $resultTypes = $client->request('GET', '/api/type/all/', [
                'headers' => $headers
            ]);
            $result = json_decode($userresult->getBody())->result;
            $types = json_decode($resultTypes->getBody())->results;
        }

        catch (RequestException $e) {
            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van de user.']);
        }




        $adminPermissions =[
            "ALERT_CREATE",
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
            "VENDING_MACHINE_DELETE",
            "TYPE_CREATE",
            "TYPE_READ",
            "TYPE_UPDATE",
            "TYPE_DELETE"
        ] ;
        $lokale_adminPermissions =[ "ALERT_CREATE_COMPANY",
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
            "VENDING_MACHINE_DELETE_COMPANY",
            "TYPE_CREATE_COMPANY",
            "TYPE_READ_COMPANY",
            "TYPE_UPDATE_COMPANY",
            "TYPE_DELETE_COMPANY"] ;
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

        return view('admin.users.edit')->with('user', $result)->with('type',$type)->with('types', $types);

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
            'base_uri' => $this->db,
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];

        $admin = false;
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
               $admin = true;
               $permissions = "[ \"ALERT_CREATE_COMPANY\",
    \"ALERT_READ_COMPANY\",
    \"ALERT_DELETE_COMPANY\",
    \"AUTHENTICATION_CREATE_COMPANY\",
    \"AUTHENTICATION_READ_COMPANY\",
    \"AUTHENTICATION_UPDATE_COMPANY\",
    \"AUTHENTICATION_DELETE_COMPANY\",
    \"AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY\",
    \"AUTHERIZED_USER_PER_MACHINE_READ_COMPANY\",
    \"AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY\",
    \"COMPANY_UPDATE_COMPANY\",
    \"USER_CREATE_COMPANY\",
    \"USER_READ_COMPANY\",
    \"USER_UPDATE_COMPANY\",
    \"USER_DELETE_COMPANY\",
    \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY\",
    \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY\",
    \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY\",
    \"VENDING_MACHINE_CREATE_COMPANY\",
    \"VENDING_MACHINE_READ_COMPANY\",
    \"VENDING_MACHINE_UPDATE_COMPANY\",
    \"VENDING_MACHINE_DELETE_COMPANY\",
    \"TYPE_CREATE_COMPANY\",
    \"TYPE_READ_COMPANY\",
    \"TYPE_UPDATE_COMPANY\",
    \"TYPE_DELETE_COMPANY\"]";
            } elseif($request->type == "admin") {
               $admin = true;
               $permissions = "[
            \"ALERT_CREATE\",
            \"ALERT_READ\",
            \"ALERT_DELETE\",
            \"AUTHENTICATION_CREATE\",
            \"AUTHENTICATION_READ\",
            \"AUTHENTICATION_UPDATE\",
            \"AUTHENTICATION_DELETE\",
            \"AUTHERIZED_USER_PER_MACHINE_CREATE\",
            \"AUTHERIZED_USER_PER_MACHINE_READ\",
            \"AUTHERIZED_USER_PER_MACHINE_DELETE\",
            \"COMPANY_CREATE\",
            \"COMPANY_READ\",
            \"COMPANY_UPDATE\",
            \"COMPANY_DELETE\",
            \"USER_CREATE\",
            \"USER_READ\",
            \"USER_UPDATE\",
            \"USER_DELETE\",
            \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE\",
            \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ\",
            \"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE\",
            \"VENDING_MACHINE_CREATE\",
            \"VENDING_MACHINE_READ\",
            \"VENDING_MACHINE_UPDATE\",
            \"VENDING_MACHINE_DELETE\",
            \"TYPE_CREATE\",
            \"TYPE_READ\",
            \"TYPE_UPDATE\",
            \"TYPE_DELETE\"
        ]";
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
                'typeId' => $request->input('typeFunctie'),
                'admin' => $admin,
                'guest' => $guest,
                'permissions' => $permissions,

            ]]);
    } catch (GuzzleException $e) {
        return Redirect::to('/admin/users')->withErrors(['De gebruiker aanpassen is niet gelukt.']);
    }
        return redirect('admin/users')->with('msg', 'De gebuiker '. $request->input('email')  .' succesvol aangepast.');
    }

    public function destroy(Request $request,$id)
    {
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('USER_DELETE', $Permissions) or in_array('USER_DELETE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
        $result = $client->request('DELETE', '/api/user/'.$id, [
            'headers' => $headers,

            ]);
    } catch (GuzzleException $e) {
        return Redirect::to('/admin/users')->withErrors(['De gebruiker verwijderen is niet gelukt.']);
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
            'base_uri' => $this->db,
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
        return Redirect::to('/admin/users')->withErrors(['Qrcode is voor de guest aanmaken is niet gelukt.']);
    }
        return redirect('admin/users')->with('msg', 'Qrcode is voor de guest aangemaakt.');
    }
}
