<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];

        $machinesresult = $client->request('GET', '/api/vendingMachine/company/'.$cid, [
            'headers' => $headers
        ]);

        $companyresult = $client->request('GET', '/api/company/'.$cid, [
            'headers' => $headers
        ]);

        $machines = json_decode($machinesresult->getBody())->results;
        $company = json_decode($companyresult->getBody())->result;

        return view('admin.units.overview')->with('machines', $machines)->with('company', $company);
    }

    public function new_index($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('VENDING_MACHINE_CREATE_COMPANY', $Permissions) or in_array('VENDING_MACHINE_CREATE', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
            abort(403);
        }
        return view('admin.units.new')->with('cid', $cid);
    }

    public function new($cid, Request $request){
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
        return Redirect::to('/admin/'.$cid.'/units/')->with('msg', 'Automaat succesvol toegevoegd.');
    }

    public function edit_index($cid, $mid, Request $request){
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

        $result = $client->request('GET', '/api/vendingMachine/'.$mid, [
            'headers' => $headers
        ]);

        $machine = json_decode($result->getBody())->result;

        return view('admin.units.edit')->with('machine', $machine);
    }

    public function edit($cid, $mid, Request $request){
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


        $result = $client->request('PUT', '/api/vendingMachine/'.$mid, [
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
                "alertLimit" => $request->input('VoorraadAlert'),
        ]]);

        return Redirect::to('/admin/'.$cid.'/units')->with('msg', 'Automaat bijgewerkt.');
    }

    public function delete($cid, $mid, Request $request){
        $AuthToken = $request->cookie('AuthToken');

        if ($AuthToken == ''){                                     //permissiecheck toevoegen, of in route
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
            $result = $client->request('DELETE', '/api/vendingMachine/' . $mid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/'.$cid.'/units')->withErrors(['Automaat verwijderen mislukt.']);
        }
        return Redirect::to('/admin/'.$cid.'/units')->with('msg', 'Automaat verwijderd.');
    }
}
