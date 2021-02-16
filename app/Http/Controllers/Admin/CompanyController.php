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
        if ($AuthToken == '' or !(in_array('COMPANY_READ', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            $result = $client->request('GET', '/api/company/all', [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::back()->withErrors(['Kan pagina niet tonen.']);
        }

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
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !in_array('COMPANY_CREATE', $Permissions)){                                                                          //permissiecheck toevoegen, of in route
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

        try {
            $result = $client->request('GET', '/api/type/company/'.$cid, [
                'headers' => $headers
            ]);

            $types = json_decode($result->getBody())->results;
        } catch (GuzzleException $e) {
            $types = [];
        }

        try {
            $result = $client->request('GET', '/api/alert/alertsAuthUser', [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/companies')->withErrors(['Kan bedrijf niet tonen.']);
        }

        $alertsreverse = json_decode($result->getBody())->results;
        $alertsfull = array_reverse($alertsreverse);
        if (count($alertsfull) > 5){
            $alertsTop = array_slice($alertsfull, 0, 5);
            $alertsRest = array_slice($alertsfull, 6);
        } else {
            $alertsTop = $alertsfull;
            $alertsRest = [];
        }

        return view('admin/companies/view')->with('company', $company)
            ->with('machines', $machines)
            ->with('types', $types)
            ->with('alertsTop', $alertsTop)
            ->with('alertsRest', $alertsRest);
    }

    public function edit_index($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('COMPANY_UPDATE', $Permissions) or in_array('COMPANY_UPDATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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
            return redirect()->back()->withErrors(['Kan bedrijf niet tonen.']);
        }
        $company = json_decode($result->getBody())->result;

        return view('admin.company.edit')->with('company', $company);
    }

    public function update($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !(in_array('COMPANY_UPDATE', $Permissions) or in_array('COMPANY_UPDATE_COMPANY', $Permissions))){                                                                          //permissiecheck toevoegen, of in route
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

        if (in_array('COMPANY_READ', $Permissions) ){
            return Redirect::to('/admin/companies')->with('company', $company)->with('msg', 'Bedrijf opgeslagen.');
        }
        return Redirect::to('/admin/company/'.$company->id)->with('company', $company)->with('msg', 'Bedrijf opgeslagen.');
    }

    public function delete($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        $Permissions = explode(';',$request->cookie('UserPermissions'));
        if ($AuthToken == '' or !in_array('COMPANY_DELETE', $Permissions)){                                                                          //permissiecheck toevoegen, of in route
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
            $result = $client->request('DELETE', '/api/company/' . $cid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/companies')->withErrors(['Bedrijf verwijderen mislukt.']);
        }
        return Redirect::to('/admin/companies')->with('msg', 'Bedrijf verwijderd.');
    }
}
