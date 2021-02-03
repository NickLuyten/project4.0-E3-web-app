@extends('layouts.template')

@php
    $permissions = explode(';', Cookie::get('UserPermissions'));
@endphp

@section('main')

@if (session()->has('apiKey'))
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">API Key</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Gebruik deze API Key om jouw nieuwe vending machine te authentiseren. <br><br>
                    <strong>{{session()->get('apiKey')}}</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif


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
                                                @if(in_array('VENDING_MACHINE_UPDATE', $permissions) or in_array('VENDING_MACHINE_UPDATE_COMPANY', $permissions)) {{--cookies voor rechten binnemhalen--}}
                                                <a href="/admin/{{$machine->companyId}}/units/{{$machine->id}}"
                                                   class="btn btn-outline-success"
                                                   data-toggle="tooltip"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endif

                                                @if(in_array('AUTHERIZED_USER_PER_MACHINE_READ', $permissions) or in_array('AUTHERIZED_USER_PER_MACHINE_READ_COMPANY', $permissions)) {{--cookies voor rechten binnemhalen--}}
                                                <a href="/admin/{{$machine->companyId}}/units/{{$machine->id}}/access"
                                                   class="btn btn-outline-success"
                                                   data-toggle="tooltip"
                                                   title="Toegang">
                                                    <i class="fas fa-user-shield"></i>
                                                </a>
                                                @endif


                                                @if(in_array('VENDING_MACHINE_DELETE', $permissions) or in_array('VENDING_MACHINE_DELETE_COMPANY', $permissions)) {{--cookies voor rechten binnemhalen--}}
                                                <a href="/admin/{{$machine->companyId}}/units/{{$machine->id}}/delete"
                                                   class="btn btn-outline-danger"
                                                   data-toggle="tooltip"
                                                   title="Delete"
                                                   onclick="return confirm('Bent u zeker dat u deze automaat wilt verwijderen?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <h5>Geen automaten</h5>
                        @endif


                        <form action="/admin/{{$company->id}}/units/new">
                            <button type="submit"
                                    class="btn btn-outline-success btn-lg btn-block"
                                    @if(!(in_array('VENDING_MACHINE_CREATE', $permissions) or in_array('VENDING_MACHINE_CREATE_COMPANY', $permissions))) {{--cookies voor rechten binnemhalen--}}
                                    disabled
                                @endif
                            >
                                <i class="fas fa-plus"></i> Automaat toevoegen
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_after')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(window).on('load', function() {
                $('#exampleModal').modal('show');
            });
    </script>


@stop
