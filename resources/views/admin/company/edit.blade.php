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
