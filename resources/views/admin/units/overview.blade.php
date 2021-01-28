@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Automaten beheren van {{$company->name}}</h3></div>

                    <div class="card-body">

                            @if($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first()}}
                                </div>
                            @endif
                                @if($msg ?? false)
                                    <div class="alert alert-success" role="alert">
                                        {{$msg}}
                                    </div>
                                @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Naam</th>
                                <th scope="col">Locatie</th>
                                <th scope="col">Voorraad</th>
                                <th scope="col">Acties</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($machines as $machine)
                                <tr>
                                    <th scope="row">{{$machine->id}}</th>
                                    <td>{{$machine->name}}</td>
                                    <td>{{$machine->location}}</td>
                                    <td>{{$machine->stock}}/{{$machine->maxNumberOfProducts}}</td>
                                    <td><a href="/admin/{{$machine->companyId}}/units/{{$machine->id}}" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="/admin/{{$company->id}}/units/new" class="btn btn-outline-success btn-lg btn-block"><i class="fas fa-plus"></i> Automaat toevoegen</a>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
