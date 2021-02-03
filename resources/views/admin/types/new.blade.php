@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Limiet aanmaken</h3></div>
                    <div class="card-body">
                        <form class="text-right" method="post" action="/admin/{{$cid}}/types/store">
                            @CSRF
                            <div class="form-group row">
                                <label for="afdeling" class="col-sm-4 col-form-label">Afdeling</label>
                                <div class="col-sm-8">
                                    <input type="text" id="afdeling" name="afdeling" class="form-control" placeholder="naam"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Type</label>
                                <div class="col-sm-8 text-left">
                                    <input type="radio" id="unlimitedchecked" name="type" value="unlim"/>
                                    <label for="unlimitedchecked">Ongelimiteerd</label>
                                    <br>
                                    <input type="radio" id="valuechecked" name="type" data-for="limiet" value="lim"/>
                                    <label for="valuechecked">Gelimiteerd per maand</label>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="limiet" class="col-sm-4 col-form-label">Limiet</label>
                                <div class="col-sm-8 input-group">
                                    <input id="limiet" name="limiet" type="number" class="form-control" placeholder="aantal" aria-label="Recipient's username" aria-describedby="basic-addon2" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">/ maand</span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Toevoegen</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <a href="/admin/companies/view/{{$cid}}" class="btn btn-outline-secondary">Annuleren</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_after')
    <script>
        $("#unlimitedchecked").on("click", function() {
            $("#limiet").prop("readonly", true);
        });
        $("#valuechecked").on("click", function() {
            $("#limiet").prop("readonly", false);
        });
    </script>
@stop
