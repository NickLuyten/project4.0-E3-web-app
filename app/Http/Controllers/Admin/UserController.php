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

            $users = json_decode($usersresult->getBody())->results;
            $types = json_decode($typesresult->getBody())->results;


            $permissions = explode(';',$request->cookie('UserPermissions'));
            $company_read_permission = "";
            foreach ($permissions as $permission) {
                if($permission == "COMPANY_READ") {

                    $company_read_permission = $permission;

                }
            }
            if($company_read_permission == "COMPANY_READ" ) {
                    $companiesresult = $client->request('GET', '/api/company/all/', [
                        'headers' => $headers
                    ]);

                    $companies = json_decode($companiesresult->getBody())->results;
                    $type="admin";

                    return view('admin.users.index')->with('users', $users)->with('types', $types)->with('companies', $companies)->with('type',$type);
                } else {
                    $companyId = $request->cookie('UserCompanyId');
                    $companyresult = $client->request('GET', '/api/company/'.$companyId, [
                        'headers' => $headers
                    ]);

                    $company = json_decode($companyresult->getBody())->result;
                    $type="lokale_admin";
                    return view('admin.users.index')->with('users', $users)->with('types', $types)->with('companies', $company)->with('type',$type);
                }


        }

        catch (RequestException $e) {
            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van de gebruikers.']);
        }

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
            $types = json_decode($typesresult->getBody())->results;

            $permissions = explode(';',$request->cookie('UserPermissions'));
            $company_read_permission = "";
            foreach ($permissions as $permission) {
                if($permission == "COMPANY_READ") {

                    $company_read_permission = $permission;

                }
            }
            if($company_read_permission == "COMPANY_READ" ) {
                $companiesresult = $client->request('GET', '/api/company/all/', [
                    'headers' => $headers
                ]);

                $companies = json_decode($companiesresult->getBody())->results;
                $type="admin";

                return view('admin.users.create')->with('types', $types)->with('companies', $companies)->with('type',$type);
            } else {
                $companyId = $request->cookie('UserCompanyId');
                $companyresult = $client->request('GET', '/api/company/'.$companyId, [
                    'headers' => $headers
                ]);

                $company = json_decode($companyresult->getBody())->result;
                $type="lokale_admin";
                return view('admin.users.create')->with('types', $types)->with('companies', $company)->with('type',$type);
            }

        }catch (RequestException $e) {
            return Redirect::back()->withErrors(['Er is iets misgelopen bij het oproepen van de gegevens.']);
        }


//        return view('admin.users.create')->with('types', $types)->with('companies', $companies);
    }


    public function new(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'firstName' => 'required|string|min:3|max:24',
            'lastName' => 'required|string|min:3|max:24',
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

        if($request->privileges == 2) {
            $permissions = [];

            for ($x = 1; $x <= 56; $x++) {

                if($request->$x != "") {
                    array_push($permissions,$request->$x);


//                    echo($request->$x . "\n");
                }
            }
            if(count($permissions) ==0) {
                $permissions = [];
            }


            if(count($permissions) ==0) {
                $guest = true;
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
                "TYPE_DELETE"];

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
                "TYPE_DELETE_COMPANY"];

            if(array_intersect($adminPermissions,$permissions) == $adminPermissions or array_intersect( $lokale_adminPermissions,$permissions) == $lokale_adminPermissions) {
                $admin=true;
            }

        } elseif ($request->privileges == 1) {
            if($request->type == "lokale_admin") {
                $admin = true;
                $permissions = [ "ALERT_CREATE_COMPANY",
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
                    "TYPE_DELETE_COMPANY"];
            } elseif($request->type == "admin") {
                $admin = true;
                $permissions = [
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
                    "TYPE_DELETE"];
            }elseif($request->type == "gebruiker") {
                $permissions = ["AUTHENTICATION_CREATE_COMPANY_OWN"];
            }elseif($request->type == "guest") {
                $permissions = [];
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
                'typeId' => $request->input('typeFunctie'),
                'admin' => $admin,
                'guest' => $guest,
                'permissions' => json_encode($permissions),

            ]
        ]);
    } catch (RequestException $e) {
        $response = $e->getResponse();
        $responseBodyAsString = json_decode($response->getBody()->getContents());
        if (isset($responseBodyAsString->message)) {
            $response = $responseBodyAsString->message;
        } else{
            $response = $responseBodyAsString->messages;
        }
        return Redirect::back()->withErrors(['Er is iets misgelopen bij het aanmaken van de gebruiker. '. json_encode($response)]);
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


            $permissions = explode(';',$request->cookie('UserPermissions'));
            $company_read_permission = "";
            foreach ($permissions as $permission) {
                if($permission == "COMPANY_READ") {

                    $company_read_permission = $permission;

                }
            }
            if($company_read_permission == "COMPANY_READ" ) {
                $companiesresult = $client->request('GET', '/api/company/all/', [
                    'headers' => $headers
                ]);

                $companies = json_decode($companiesresult->getBody())->results;
                $typePermission="admin";


            } else {
                $companyId = $request->cookie('UserCompanyId');
                $companyresult = $client->request('GET', '/api/company/'.$companyId, [
                    'headers' => $headers
                ]);

                $company = json_decode($companyresult->getBody())->result;
                $typePermission="lokale_admin";

            }

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

        if(array_intersect($adminPermissions,$result->permissions)   == $adminPermissions){
            $admin = true;
            $lokale_admin = false;
            $gebruiker = false;
            $guest = false;
        } elseif (array_intersect($lokale_adminPermissions,$result->permissions) == $lokale_adminPermissions) {
            $admin = false;
            $lokale_admin = true;
            $gebruiker = false;
            $guest = false;
        }elseif (array_intersect($gebruikerPermissions,$result->permissions) == $gebruikerPermissions) {
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

        if($company_read_permission == "COMPANY_READ" ) {

            return view('admin.users.edit')->with('user', $result)->with('types', $types)->with('companies', $companies)->with('type',$type)->with('typePermission',$typePermission);
        } else {

            return view('admin.users.edit')->with('user', $result)->with('types', $types)->with('company', $company)->with('type',$type)->with('typePermission',$typePermission);
        }




    }


       public function update(Request $request, $id)
    {

        $request->validate([
            'email' => 'required|string',
            'firstName' => 'required|string|min:3|max:24',
            'lastName' => 'required|string|min:3|max:24',

        ]);


        $AuthToken = $request->cookie('AuthToken');

        if ($AuthToken == ''){
            abort(403);
        }

        $client = new Client([
            'base_uri' => $this->db,
            'timeout'  => 2000.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];

        $admin = false;
        $guest = false;

        if($request->privileges == 2) {
            $permissions = [];

            for ($x = 1; $x <= 56; $x++) {

                if($request->$x != "") {
                    array_push($permissions,$request->$x);


//                    echo($request->$x . "\n");
                }
            }
            if(count($permissions) ==0) {
                $permissions = [];
            }


            if(count($permissions) ==0) {
                    $guest = true;
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
                "TYPE_DELETE"];

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
                "TYPE_DELETE_COMPANY"];

            if(array_intersect($adminPermissions,$permissions) == $adminPermissions or array_intersect( $lokale_adminPermissions,$permissions) == $lokale_adminPermissions) {
                $admin=true;
            }




        } elseif ($request->privileges == 1) {
           if($request->type == "lokale_admin") {
               $admin = true;
               $permissions = [ "ALERT_CREATE_COMPANY",
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
                   "TYPE_DELETE_COMPANY"];
            } elseif($request->type == "admin") {
               $admin = true;
               $permissions = [
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
                   "TYPE_DELETE"];
           }elseif($request->type == "gebruiker") {
               $permissions = ["AUTHENTICATION_CREATE_COMPANY_OWN"];
           }elseif($request->type == "guest") {
               $permissions = [];
               $guest= true;
           }

        }

//
//    try {
        $result = $client->request('PUT', '/api/user/'.$id, [
            'headers' => $headers,
            'form_params' => [
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'companyId' => $request->input('companyId'),
                'typeId' => $request->input('typeFunctie'),
                'admin' => $admin,
                'guest' => $guest,
                'permissions' => json_encode($permissions),

            ]]);

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

        if ($AuthToken == ''){   //permissiecheck toevoegen, of in route
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
