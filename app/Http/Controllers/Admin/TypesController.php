<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class TypesController extends Controller
{
    public function new_index($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken == ''){                                                                          //permissiecheck toevoegen, of in route
            abort(403);
        }

        return view('admin/types/new')->with('cid', $cid);
    }

    public function new_store($cid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken == ''){                                                   //permissiecheck toevoegen, of in route
            abort(403);
        }

        $client = new Client([
            'base_uri' => $this->db,
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];


        if ($request->input('type') == "lim"){
            try {
                $result = $client->request('POST', '/api/type/', [
                    'headers' => $headers,
                    'form_params' => [
                        'name' => $request->input('afdeling'),
                        'companyId' => $cid,
                        'sanitizerLimitPerMonth' => $request->input('limiet')
                    ]
                ]);
            } catch (GuzzleException $e) {
                return Redirect::to('/admin/companies/view/'.$cid)->withErrors(['Limiet toegevoegen mislukt. Gelieve opnieuw te proberen.'])->with('collapseOpen', "");
            }
        } else {
            try {
                $result = $client->request('POST', '/api/type/', [
                    'headers' => $headers,
                    'form_params' => [
                        'name' => $request->input('afdeling'),
                        'companyId' => $cid
                    ]
                ]);
            } catch (GuzzleException $e) {
                return Redirect::to('/admin/companies/view/'.$cid)->withErrors(['Limiet toegevoegen mislukt. Gelieve opnieuw te proberen.'])->with('collapseOpen', "");
            }
        }

        return Redirect::to('/admin/companies/view/'.$cid)->with('msg', 'Limiet succesvol toegevoegd.')->with('collapseOpen', "");
    }


    public function edit_index($cid, $tid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken == ''){                                                   //permissiecheck toevoegen, of in route
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
            $result = $client->request('GET', '/api/type/'.$tid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            return redirect()->back()->withErrors(['Kan type niet tonen.']);
        }

        $type = json_decode($result->getBody())->result;

        return view('admin/types/edit')->with('type', $type)->with('cid', $cid);
    }

    public function edit_update($cid, $tid, Request $request){
        $AuthToken = $request->cookie('AuthToken');
        if ($AuthToken == ''){                                                   //permissiecheck toevoegen, of in route
            abort(403);
        }

        $client = new Client([
            'base_uri' => $this->db,
            'timeout'  => 2.0,
        ]);
        $headers = [
            'Authorization' => 'Bearer ' . $AuthToken
        ];

        if ($request->input('type') == "lim"){
            try {
                $result = $client->request('PUT', '/api/type/'.$tid, [
                    'headers' => $headers,
                    'form_params' => [
                        'name' => $request->input('afdeling'),
                        'sanitizerLimitPerMonth' => $request->input('limiet')
                    ]
                ]);
            } catch (GuzzleException $e) {
                return Redirect::to('/admin/companies/view/'.$cid)->withErrors(['Limiet bewerken mislukt. Gelieve opnieuw te proberen.'])->with('collapseOpen', "");
            }
        } else {
            try {
                $result = $client->request('PUT', '/api/type/'.$tid, [
                    'headers' => $headers,
                    'form_params' => [
                        'name' => $request->input('afdeling')
                    ]
                ]);
            } catch (GuzzleException $e) {
                return Redirect::to('/admin/companies/view/'.$cid)->withErrors(['Limiet bewerken mislukt. Gelieve opnieuw te proberen.'])->with('collapseOpen', "");
            }
        }

        return Redirect::to('/admin/companies/view/'.$cid)->with('msg', 'Limiet succesvol opgeslagen.')->with('collapseOpen', "");
    }

    public function delete($cid, $tid, Request $request){
        $AuthToken = $request->cookie('AuthToken');

        if ($AuthToken == ''){                                     //permissiecheck toevoegen, of in route
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
            $result = $client->request('DELETE', '/api/type/' . $tid, [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            return Redirect::to('/admin/companies/view/'.$cid)->withErrors(['Type verwijderen mislukt: '. $responseBodyAsString->message])->with('collapseOpen', "");
        }
        return Redirect::to('/admin/companies/view/'.$cid)->with('msg', 'Type succesvol verwijderd.')->with('collapseOpen', "");
    }
}
