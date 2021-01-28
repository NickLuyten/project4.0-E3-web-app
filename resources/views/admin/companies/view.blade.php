@extends('layouts.template')

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
                                <h5 class="card-header">Bedrijfsinfo <span class="float-right"><a href="/admin/company/{{$company->id}}/edit" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a></span></h5>
                                <div class="card-body">
                                    <p class="card-text"><strong>Naam: </strong>{{$company->name}}</p>
                                    <p class="card-text"><strong>Locatie: </strong>{{$company->location}}</p>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <h5 class="card-header">Automaten in bedrijf <span class="float-right"><a href="/admin/{{$company->id}}/units" class="btn btn-sm btn-secondary">Naar automaten beheren <i class="fas fa-arrow-right"></i></a></span></h5>
                                <div class="card-body">

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

                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
