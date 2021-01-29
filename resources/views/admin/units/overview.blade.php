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
                        @if(session()->has('msg'))
                            <div class="alert alert-success" role="alert">
                                {{session()->get('msg')}}
                            </div>
                        @endif

                            @if (!empty($machines))
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
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="/admin/{{$machine->companyId}}/units/{{$machine->id}}" class="btn btn-outline-success"
                                                       data-toggle="tooltip"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="/admin/{{$machine->companyId}}/units/{{$machine->id}}/access" class="btn btn-outline-success"
                                                       data-toggle="tooltip"
                                                       title="Toegang">
                                                        <i class="fas fa-user-shield"></i>
                                                    </a>
                                                    <a href="/admin/{{$machine->companyId}}/units/{{$machine->id}}/delete" class="btn btn-outline-danger"
                                                       data-toggle="tooltip"
                                                       title="Delete"
                                                       onclick="return confirm('Bent u zeker dat u deze automaat wilt verwijderen?');">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                <h5>Geen automaten</h5>
                            @endif


                        <a href="/admin/{{$company->id}}/units/new" class="btn btn-outline-success btn-lg btn-block"><i class="fas fa-plus"></i> Automaat toevoegen</a>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
