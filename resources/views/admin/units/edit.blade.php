@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Automaat bewerken</h3></div>
                    <div class="card-body">
                        <form class="text-right" method="POST" action="/admin/{{$machine->companyId}}/units/{{$machine->id}}/update/">
                            @CSRF
                            @method('PUT')
                            <div class="form-group row">
                                <label for="naam" class="col-sm-4 col-form-label">Naam</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="naam" name="naam" placeholder="Naam" value="{{$machine->name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="locatie" class="col-sm-4 col-form-label">Locatie</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="locatie" name="locatie" value="{{$machine->location}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="welkomsboodschap" class="col-sm-4 col-form-label">Welkomsboodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="welkomsboodschap" name="welkomsboodschap">{{$machine->welcomeMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Afnameboodschap" class="col-sm-4 col-form-label">Afnameboodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="Afnameboodschap" name="Afnameboodschap">{{$machine->handGelMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="voorraadboodschap" class="col-sm-4 col-form-label">Voorraad leeg boodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="voorraadboodschap" name="voorraadboodschap">{{$machine->handGelOutOfStockMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Authenticatieboodschap" class="col-sm-4 col-form-label">Authenticatiefout boodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="Authenticatieboodschap" name="Authenticatieboodschap">{{$machine->authenticationFailedMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foutboodschap" class="col-sm-4 col-form-label">Overige foutboodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="foutboodschap" name="foutboodschap">{{$machine->errorMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Capaciteit" class="col-sm-4 col-form-label">Capaciteit</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="Capaciteit" name="Capaciteit" value="{{$machine->maxNumberOfProducts}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Voorraad" class="col-sm-4 col-form-label">Voorraad</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="Voorraad" name="Voorraad" value="{{$machine->stock}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Opslaan</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <a href="/admin/{{$machine->companyId}}/units" class="btn btn-outline-secondary">Annuleren</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
