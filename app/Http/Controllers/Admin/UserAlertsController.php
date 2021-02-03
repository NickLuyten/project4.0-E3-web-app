<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class UserAlertsController extends Controller
{
    public function overview($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ', $Permissions) or in_array('USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $result = $client->request('GET', '/api/userThatReceiveAlertsFromVendingMachine/all', [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::back()->withErrors(['Kan de aangevraagde pagina niet tonen.']);
        }

        $useralerts = json_decode($result->getBody())->results;

        return view('admin/useralerts/overview')->with('useralerts', $useralerts)->with('cid', $cid);
    }

    public function new_index($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
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
            $result = $client->request('GET', '/api/user/all', [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::back()->withErrors(['Kan de aangevraagde pagina niet tonen.']);
        }

        $users = json_decode($result->getBody())->results;

        try {
            $result = $client->request('GET', '/api/vendingMachine/company/'.$cid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::back()->withErrors(['Kan de aangevraagde pagina niet tonen.']);
        }

        $machines = json_decode($result->getBody())->results;


        return view('admin/useralerts/new')->with('cid', $cid)->with('users', $users)->with('machines', $machines);

    }

    public function new_store($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken == ''){                                                   //permissiecheck toevoegen, of in route
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
            $result = $client->request('POST', '/api/userThatReceiveAlertsFromVendingMachine', [
                'headers' => $headers,
                'form_params' => [
                    'userId' => $request->input('user'),
                    'vendingMachineId' => $request->input('machine')
                ]
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/'.$cid.'/useralerts')->withErrors(['Alarmontvanger toegevoegen mislukt. Gelieve opnieuw te proberen.']);
        }
        return Redirect::to('/admin/'.$cid.'/useralerts')->with('msg', 'Alarmontvanger succesvol toegevoegd.');
    }

    public function delete($cid, $aid, Request $request){
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
            $result = $client->request('DELETE', '/api/userThatReceiveAlertsFromVendingMachine/' . $aid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            return Redirect::to('/admin/'.$cid.'/useralerts')->withErrors(['Alarmontvanger verwijderen mislukt: '. $responseBodyAsString->message]);
        }
        return Redirect::to('/admin/'.$cid.'/useralerts')->with('msg', 'Alarmontvanger verwijderd.');
    }
}
