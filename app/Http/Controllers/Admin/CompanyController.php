<?php

namespace App\Http\Controllers\Admin;

use Cookie;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class CompanyController extends Controller
{
    public function overview(Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !in_array('COMPANY_READ', $Permissions)){                                                                          //permissiecheck toevoegen, of in route
            abort(403);
        }

        $client = new Client([
            'base_uri' => 'https://project4-restserver.herokuapp.com',
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];

        $result = $client->request('GET', '/api/company/all', [
            'headers' => $headers
        ]);

        $companies = json_decode($result->getBody())->results;

        return view('admin/companies/overview')->with('companies', $companies)->with('msg', $request->msg);
    }

    public function new_index(Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !in_array('COMPANY_CREATE', $Permissions)){                                                                          //permissiecheck toevoegen, of in route
            abort(403);
        }
        return view('admin.companies.new');
    }

    public function new(Request $request){
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
            $result = $client->request('POST', '/api/company/', [
                'headers' => $headers,
                'form_params' => [
                    'name' => $request->input('naam'),
                    'location' => $request->input('locatie'),
                    "welcomeMessage" => $request->input('welkomsboodschap'),
                    'handGelMessage' => $request->input('Afnameboodschap'),
                    "handGelOutOfStockMessage" => $request->input('voorraadboodschap'),
                    "authenticationFailedMessage" => $request->input('Authenticatieboodschap'),
                    "limitHandSanitizerReacedMessage" => $request->input('Limietboodschap'),
                    "errorMessage" => $request->input('foutboodschap')
                ]
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/companies')->withErrors(['Bedrijf toegevoegen mislukt. Gelieve opnieuw te proberen.']);
        }
        return Redirect::to('/admin/companies')->with('msg', 'Bedrijf succesvol toegevoegd.');
    }

    public function view($cid, Request $request){
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
            $result = $client->request('GET', '/api/company/'.$cid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/companies')->withErrors(['Kan bedrijf niet tonen.']);
        }

        $company = json_decode($result->getBody())->result;

        try {
            $result = $client->request('GET', '/api/vendingMachine/company/'.$cid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/companies')->withErrors(['Kan bedrijf niet tonen.']);
        }

        $machines = json_decode($result->getBody())->results;

        return view('admin/companies/view')->with('company', $company)->with('machines', $machines);
    }

    public function edit_index($cid, Request $request){
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
            $result = $client->request('GET', '/api/company/'.$cid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return redirect()->back()->withErrors(['Kan bedrijf niet tonen.']);
        }
        $company = json_decode($result->getBody())->result;

        return view('admin.company.edit')->with('company', $company);
    }

    public function update($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $permissions = explode(';',$request->cookie('UserPermissions'));
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
            $result = $client->request('PUT', '/api/company/'.$cid, [
                'headers' => $headers,
                'form_params' => [
                    'name' => $request->input('naam'),
                    'location' => $request->input('locatie'),
                    "welcomeMessage" => $request->input('welkomsboodschap'),
                    'handGelMessage' => $request->input('Afnameboodschap'),
                    "handGelOutOfStockMessage" => $request->input('voorraadboodschap'),
                    "authenticationFailedMessage" => $request->input('Authenticatieboodschap'),
                    "limitHandSanitizerReacedMessage" => $request->input('Limietboodschap'),
                    "errorMessage" => $request->input('foutboodschap')
                ]
            ]);
        } catch (GuzzleException $e) {
            return redirect()->back()->withErrors(['Kan bedrijf niet aanpassen.']);
        }
        $company = json_decode($result->getBody())->result;

        if (in_array('COMPANY_READ', $permissions) ){
            return Redirect::to('/admin/companies')->with('company', $company)->with('msg', 'Bedrijf opgeslagen.');
        }
        return Redirect::to('/admin/company/'.$company->id)->with('company', $company)->with('msg', 'Bedrijf opgeslagen.');
    }

    public function delete($cid, Request $request){
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
            $result = $client->request('DELETE', '/api/company/' . $cid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/companies')->withErrors(['Bedrijf verwijderen mislukt.']);
        }
        return Redirect::to('/admin/companies')->with('msg', 'Bedrijf verwijderd.');
    }
}
