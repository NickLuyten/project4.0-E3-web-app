@extends('layouts.template')

@php
    $permissions = explode(';', Cookie::get('UserPermissions'));
@endphp

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>{{$company->name}}</h3></div>

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

                        <div class="card">
                            <h5 class="card-header">Bedrijfsinfo
                                @if(in_array('COMPANY_UPDATE', $permissions) or in_array('COMPANY_UPDATE_COMPANY', $permissions))
                                    <span class="float-right"><a
                                            href="/admin/company/{{$company->id}}/edit"
                                            class="btn btn-sm btn-outline-secondary"><i
                                                class="fas fa-edit"></i></a></span>
                                @endif
                            </h5>
                            <div class="card-body">
                                <p class="card-text"><strong>Naam: </strong>{{$company->name}}</p>
                                <p class="card-text"><strong>Locatie: </strong>{{$company->location}} <a id="link"
                                                                                                         class="btn btn-sm btn-outline-secondary float-right"
                                                                                                         target="_blank">Op
                                        kaart bekijken <i class="fas fa-external-link-alt"></i></a></p>
                                <p><a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#messages"
                                      role="button" aria-expanded="false" aria-controls="messages">
                                        Boodschappen bekijken <i class="fas fa-caret-down"></i>
                                    </a></p>
                                <div class="collapse" id="messages">
                                    <div class="card card-body">
                                        <p><strong>Welkom boodschap: </strong>{{$company->welcomeMessage}}</p>
                                        <p><strong>Afname boodschap: </strong>{{$company->handGelMessage}}</p>
                                        <p><strong>Voorraad leeg
                                                boodschap: </strong>{{$company->handGelOutOfStockMessage}}</p>
                                        <p><strong>Authenticatiefout
                                                boodschap: </strong>{{$company->authenticationFailedMessage}}</p>
                                        <p><strong>Limiet bereikt
                                                boodschap: </strong>{{$company->limitHandSanitizerReacedMessage}}</p>
                                        <p><strong>Algemene foutboodschap: </strong>{{$company->errorMessage}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                            @if(in_array('ALERT_READ', $permissions) or in_array('ALERT_READ_COMPANY', $permissions))
                            <div class="card mt-3">
                                <h5 class="card-header">Alarmen in bedrijf

                                        <span class="float-right"><a
                                                href="/admin/{{$company->id}}/useralerts" class="btn btn-sm btn-secondary">Naar gebruiker alarmen beheren <i
                                                    class="fas fa-arrow-right"></i></a></span>

                                </h5>
                                <div class="card-body">

                                    @if (!empty($alertsTop))
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Tijdstip</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Alarm</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($alertsTop as $alert)
                                                <tr>
                                                    <th scope="row">{{date('d/m/y - H:i',strtotime($alert->createdAt))}}</th>
                                                    <td>{{$alert->type}}</td>
                                                    <td>{{$alert->melding}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @if (count($alertsRest) != 0)
                                            <button class="btn btn-outline-secondary btn-block" type="button" data-toggle="collapse" data-target="#alertsrest" aria-expanded="false" aria-controls="alertsrest">
                                                Oudere alarmen bekijken <i class="fas fa-caret-down"></i>
                                            </button>
                                            <div class="collapse" id="alertsrest">
                                                <table class="table">
                                                    <tbody>
                                                    @foreach($alertsRest as $alert)
                                                        <tr>
                                                            <th scope="row">{{date('d/m/y - H:i',strtotime($alert->createdAt))}}</th>
                                                            <td>{{$alert->type}}</td>
                                                            <td>{{$alert->melding}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                    @endif

                                    @else
                                        <h5>Geen alarmen voor u</h5>
                                    @endif


                                </div>
                            </div>
                            @endif

                        <div class="card mt-3">
                            <h5 class="card-header">Automaten in bedrijf
                                @if(in_array('VENDING_MACHINE_READ', $permissions) or in_array('VENDING_MACHINE_READ_COMPANY', $permissions))
                                    <span class="float-right"><a
                                            href="/admin/{{$company->id}}/units" class="btn btn-sm btn-secondary">Naar automaten beheren <i
                                                class="fas fa-arrow-right"></i></a></span>
                                @endif
                            </h5>
                            <div class="card-body">

                                @if (!empty($machines))
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Naam</th>
                                            <th scope="col">Locatie</th>
                                            <th scope="col">Voorraad</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($machines as $machine)
                                            <tr>
                                                <th scope="row">{{$machine->id}}</th>
                                                <td>{{$machine->name}}</td>
                                                <td>{{$machine->location}}</td>
                                                <td>{{$machine->stock}}/{{$machine->maxNumberOfProducts}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h5>Geen automaten</h5>
                                @endif


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_after')
    <script type="text/javascript">
        jQuery(
            function ($) {
                var q = encodeURIComponent('{{$company->location}}');
                $('#link')
                    .attr('href',
                        "https://www.google.com/maps/search/" + q);
            }
        );
    </script>
@endsection
