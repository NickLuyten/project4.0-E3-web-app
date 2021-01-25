<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class UnitsController extends Controller
{
    public function overview($cid, Request $request){
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

        $result = $client->request('GET', '/api/vendingMachine/company/'.$cid, [
            'headers' => $headers
        ]);

        $data = json_decode($result->getBody())->results;

        return view('admin.units.overview')->with('data', $data);
    }

    public function new_index($cid){
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
                "errorMessage" => $request->input('foutboodschap'),
                "stock" => $request->input('Capaciteit'),
                "companyId" => $cid
            ]
        ]);
        return Redirect::to('/admin/'.$cid.'/units/');
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
                "errorMessage" => $request->input('foutboodschap'),
                "stock" => $request->input('Voorraad'),
        ]]);

        return Redirect::to('/admin/'.$cid.'/units/');
    }
}
