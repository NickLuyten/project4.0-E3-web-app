<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class UnitsController extends Controller
{
    public function overview($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));

        if ($AuthToken == '' or !(in_array('VENDING_MACHINE_READ_COMPANY', $Permissions) or in_array('VENDING_MACHINE_READ', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $machinesresult = $client->request('GET', '/api/vendingMachine/company/' . $cid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::back()->withErrors(['kan de gevraagde pagina niet tonen.']);
        }

        try {
            $companyresult = $client->request('GET', '/api/company/' . $cid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::back()->withErrors(['kan de gevraagde pagina niet tonen.']);
        }

        $machines = json_decode($machinesresult->getBody())->results;
        $company = json_decode($companyresult->getBody())->result;

        return view('admin.units.overview')->with('machines', $machines)->with('company', $company)->with('permissions', $Permissions);
    }

    public function new_index($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('VENDING_MACHINE_CREATE_COMPANY', $Permissions) or in_array('VENDING_MACHINE_CREATE', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $result = $client->request('GET', '/api/company/'.$cid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/'.$cid.'/units/')->withErrors('Automaat toegevoegen mislukt. Gelieve opnieuw te proberen.');
        }

        $company = json_decode($result->getBody())->result;
        return view('admin.units.new')->with('cid', $cid)->with('company', $company);
    }

    public function new($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('VENDING_MACHINE_CREATE_COMPANY', $Permissions) or in_array('VENDING_MACHINE_CREATE', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $result = $client->request('POST', '/api/vendingMachine', [
                'headers' => $headers,
                'form_params' => [
                    'name' => $request->input('naam'),
                    "maxNumberOfProducts" => $request->input('Capaciteit'),
                    'location' => $request->input('locatie'),
                    "welcomeMessage" => $request->input('welkomsboodschap'),
                    'handGelMessage' => $request->input('Afnameboodschap'),
                    "handGelOutOfStockMessage" => $request->input('voorraadboodschap'),
                    "authenticationFailedMessage" => $request->input('Authenticatieboodschap'),
                    "limitHandSanitizerReacedMessage" => $request->input('Limietboodschap'),
                    "errorMessage" => $request->input('foutboodschap'),
                    "stock" => $request->input('Capaciteit'),
                    "alertLimit" => $request->input('VoorraadAlert'),
                    "companyId" => $cid
                ]
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/'.$cid.'/units/')->withErrors('Automaat toegevoegen mislukt. Gelieve opnieuw te proberen.');
        }
        $apiKey = json_decode($result->getBody())->result->apiKey;
        return Redirect::to('/admin/'.$cid.'/units/')->with('msg', 'Automaat succesvol toegevoegd.')->with('apiKey', $apiKey);
    }

    public function edit_index($cid, $mid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('VENDING_MACHINE_UPDATE', $Permissions) or in_array('VENDING_MACHINE_UPDATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $result = $client->request('GET', '/api/vendingMachine/' . $mid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::back()->withErrors(['Kan de gevraagde pagina niet tonen.']);
        }

        $machine = json_decode($result->getBody())->result;

        return view('admin.units.edit')->with('machine', $machine);
    }

    public function edit($cid, $mid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('VENDING_MACHINE_UPDATE', $Permissions) or in_array('VENDING_MACHINE_UPDATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $result = $client->request('PUT', '/api/vendingMachine/update/' . $mid, [
                'headers' => $headers,
                'form_params' => [
                    'name' => $request->input('naam'),
                    "maxNumberOfProducts" => $request->input('Capaciteit'),
                    'location' => $request->input('locatie'),
                    "welcomeMessage" => $request->input('welkomsboodschap'),
                    'handGelMessage' => $request->input('Afnameboodschap'),
                    "handGelOutOfStockMessage" => $request->input('voorraadboodschap'),
                    "authenticationFailedMessage" => $request->input('Authenticatieboodschap'),
                    "limitHandSanitizerReacedMessage" => $request->input('Limietboodschap'),
                    "errorMessage" => $request->input('foutboodschap'),
                    "stock" => $request->input('Voorraad'),
                    "alertLimit" => $request->input('VoorraadAlert')
                ]]);
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if (isset($responseBodyAsString->message)) {
                $response = $responseBodyAsString->message;
            } else{
                $response = $responseBodyAsString->messages;
            }
            return Redirect::to('/admin/'.$cid.'/units')->WithErrors([ 'Automaat bijgewerken mislukt: '. implode($response) ]);
        }

        return Redirect::to('/admin/'.$cid.'/units')->with('msg', 'Automaat bijgewerkt.');
    }

    public function delete($cid, $mid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('VENDING_MACHINE_DELETE', $Permissions) or in_array('VENDING_MACHINE_DELETE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $result = $client->request('DELETE', '/api/vendingMachine/' . $mid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/'.$cid.'/units')->withErrors(['Automaat verwijderen mislukt.']);
        }
        return Redirect::to('/admin/'.$cid.'/units')->with('msg', 'Automaat verwijderd.');
    }

    public function access_index($cid, $mid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('AUTHERIZED_USER_PER_MACHINE_READ', $Permissions) or in_array('AUTHERIZED_USER_PER_MACHINE_READ_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $AuthorizedResult = $client->request('GET', '/api/autherizedUserPerMachine/vendingmachine/' . $mid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/'.$cid.'/units')->withErrors(['Kan gebruikers per automaat niet laden. Kan toegangspagina niet tonen.']);
        }
        try {
            $CompanyUsersResult = $client->request('GET', '/api/user/all', [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/'.$cid.'/units')->withErrors(['Kan gebruikers van bedrijf niet laden. Kan toegangspagina niet tonen.']);
        }


        $AuthorizedUsers = json_decode($AuthorizedResult->getBody())->results;
        $CompanyUsers = json_decode($CompanyUsersResult->getBody())->results;


        return view('admin.units.access')->with('AuthorizedUsers', $AuthorizedUsers)
                                                ->with('CompanyUsers', $CompanyUsers)
                                                ->with('mid', $mid)
                                                ->with('cid', $cid);
    }

    public function access_update($cid, $mid, $uid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('AUTHERIZED_USER_PER_MACHINE_CREATE', $Permissions) or in_array('AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
            abort(403);
        }

        $client = new Client([
            'base_uri' => $this->db,
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];

        if ($request->has('access')) { //toegang toevoegen
            try {
                $result = $client->request('POST', '/api/autherizedUserPerMachine/', [
                    'headers' => $headers,
                    'form_params' => [
                        'userId' => $uid,
                        "vendingMachineId" => $mid
                    ]]);
            } catch (GuzzleException $e) {
                return Redirect::to('/admin/'.$cid.'/units/'. $mid . '/access')->withErrors(['Kan toegang niet aanpassen.']);
            }
            return Redirect::to('/admin/'.$cid.'/units/'. $mid . '/access')->with('msg', 'Toegang aangemaakt.');
        }

        else {  //toegang verwijderen
            try {
                $result = $client->request('DELETE', '/api/autherizedUserPerMachine/user/'. $uid .'/vendingmachine/'. $mid, [
                    'headers' => $headers]);
            } catch (GuzzleException $e) {
                return Redirect::to('/admin/'.$cid.'/units/'. $mid . '/access')->withErrors(['Kan toegang niet aanpassen.']);
            }
            return Redirect::to('/admin/'.$cid.'/units/'. $mid . '/access')->with('msg', 'Toegang verwijderd.');
        }
    }

    public function refill($cid, $mid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('VENDING_MACHINE_UPDATE', $Permissions) or in_array('VENDING_MACHINE_UPDATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $Result = $client->request('PUT', '/api/vendingMachine/handgelBijVullen/' . $mid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/'.$cid.'/units')->withErrors(['Voorraad aanvullen mislukt.']);
        }

        return Redirect::to('/admin/'.$cid.'/units')->with('msg', 'Voorraad bijgevuld.');
    }

    public function requestapikey($cid, $mid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('VENDING_MACHINE_UPDATE', $Permissions) or in_array('VENDING_MACHINE_UPDATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $Result = $client->request('PUT', '/api/vendingMachine/apiKey/' . $mid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/'.$cid.'/units')->withErrors(['Nieuwe API key aanvragen mislukt.']);
        }

        $apiKey = json_decode($Result->getBody())->result->apiKey;

        return Redirect::to('/admin/'.$cid.'/units')->with('apiKey', $apiKey);
    }

}
