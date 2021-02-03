@extends('layouts.template')

@php
    $permissions = explode(';', Cookie::get('UserPermissions'));
@endphp

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Gebruiker alarmen beheren</h3></div>

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
                                <th scope="col">Id</th>
                                <th scope="col">UserId</th>
                                <th scope="col">VendingMachineId</th>
                                <th scope="col">Acties</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($useralerts as $useralert)
                                <tr>
                                    <th scope="row">{{$useralert->id}}</th>
                                    <td>{{$useralert->userId}}</td>
                                    <td>{{$useralert->vendingMachineId}}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if (in_array('USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE', $permissions) or in_array('USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY', $permissions))
                                                <a href="/admin/{{$cid}}/useralerts/delete/{{$useralert->id}}" class="btn btn-outline-danger" onclick="return confirm('Bent u zeker dat u deze alarmen wilt verwijderen voor deze gebruiker?');">
                                                    <i class="fas fa-trash-alt"></i></a>
                                            @endif
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <form action="/admin/{{$cid}}/useralerts/new">
                            <button class="btn btn-outline-success btn-lg btn-block"
                                    @if (!(in_array('USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE', $permissions) or in_array('USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY', $permissions)))
                                    disabled
                                @endif
                            >
                                <i class="fas fa-plus"></i> Alarmontvanger toevoegen
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
