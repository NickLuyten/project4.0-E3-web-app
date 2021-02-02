@extends('layouts.template')

@php
    $permissions = explode(';', Cookie::get('UserPermissions'));
@endphp

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Bedrijven beheren</h3></div>

                    <div class="card-body">

                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first()}}
                            </div>
                        @endif
                        @if(session()->has('msg'))
                            <div class="alert alert-success" role="alert">
                                {{session()->get('msg')}}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Naam</th>
                                <th scope="col">Locatie</th>
                                <th scope="col">Acties</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $company)
                                <tr>
                                    <th scope="row">{{$company->id}}</th>
                                    <td>{{$company->name}}</td>
                                    <td>{{$company->location}}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if (in_array('COMPANY_READ', $permissions))
                                                <a href="/admin/companies/view/{{$company->id}}" class="btn btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                            @endif
                                                @if (in_array('COMPANY_DELETE', $permissions))
                                                    <a href="/admin/companies/delete/{{$company->id}}" class="btn btn-outline-danger" onclick="return confirm('Bent u zeker dat u dit bedrijf wilt verwijderen?');">
                                                        <i class="fas fa-trash-alt"></i></a>
                                                @endif
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                            <form action="/admin/companies/new">
                                <button class="btn btn-outline-success btn-lg btn-block"
                                @if (!in_array('COMPANY_CREATE', $permissions))
                                            disabled
                                    @endif
                                >
                                    <i class="fas fa-plus"></i> Bedrijf toevoegen
                                </button>
                            </form>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
