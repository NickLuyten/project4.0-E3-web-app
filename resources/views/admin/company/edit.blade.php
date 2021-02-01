@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Bedrijf bewerken</h3></div>
                    <div class="card-body">
                        <form class="text-right" method="post" action="/admin/company/{{$company->id}}/update">
                            @CSRF
                            <div class="form-group row">
                                <label for="naam" class="col-sm-4 col-form-label">Naam</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="naam" name="naam" value="{{$company->name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="locatie" class="col-sm-4 col-form-label">Locatie</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="locatie" name="locatie" value="{{$company->location}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="welkomsboodschap" class="col-sm-4 col-form-label">Welkomsboodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="welkomsboodschap" name="welkomsboodschap" placeholder="Welkomsboodschap">{{$company->welcomeMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Afnameboodschap" class="col-sm-4 col-form-label">Afnameboodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="Afnameboodschap" name="Afnameboodschap" placeholder="Boodschap na afname">{{$company->handGelMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="voorraadboodschap" class="col-sm-4 col-form-label">Voorraad leeg boodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="voorraadboodschap" name="voorraadboodschap" placeholder="Voorraad leeg boodschap">{{$company->handGelOutOfStockMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Authenticatieboodschap" class="col-sm-4 col-form-label">Authenticatiefout boodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="Authenticatieboodschap" name="Authenticatieboodschap" placeholder="Authenticatiefout boodschap">{{$company->authenticationFailedMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Limietboodschap" class="col-sm-4 col-form-label">Limiet bereikt boodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="Limietboodschap" name="Limietboodschap" placeholder="Limiet bereikt boodschap">{{$company->limitHandSanitizerReacedMessage}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foutboodschap" class="col-sm-4 col-form-label">Overige foutboodschap</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="foutboodschap" name="foutboodschap" placeholder="Foutboodschap">{{$company->errorMessage}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Opslaan</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
