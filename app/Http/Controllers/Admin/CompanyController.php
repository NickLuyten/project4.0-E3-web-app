<?php

namespace App\Http\Controllers\Admin;

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
                    'location' => $request->input('locatie')
                ]
            ]);
        } catch (GuzzleException $e) {
            return Redirect::to('/admin/companies')->withErrors(['Bedrijf toegevoegen mislukt. Gelieve opnieuw te proberen.']);
        }
        return Redirect::to('/admin/companies')->with('msg', 'Bedrijf succesvol toegevoegd.');
    }
}
