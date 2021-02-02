@extends('layouts.template')
@section('css_after')
    <style>
        ul {
            list-style-type: none;
        }
    </style>
@endsection
@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Gebruiker {{$user->firstName}} bewerken</h3></div>
                    <div class="card-body">
                        <form class="text-right" method="post" action="/profile/update">
                            @CSRF
                            <div class="form-group row">
                                <label for="firstName" class="col-sm-4 col-form-label">Voornaam</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName" name="firstName" placeholder="Voornaam" value="{{$user->firstName}}">
                                </div>
                                @error('firstName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="lastName" class="col-sm-4 col-form-label">Achternaam</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" placeholder="Achternaam" value="{{$user->lastName}}">
                                </div>
                                @error('lastName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{$user->email}}">
                                </div>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Opslaan</button>
                                </div>
                            </div>
                                <div class="form-group row">
                                <div class="col-7">
                                    <a href="/profile/password/edit" class="btn btn-outline-success">Wachtwoord veranderen</a>
                                </div>
                                <div class="col-5">
                                    <a href="/dashboard" class="btn btn-outline-secondary">Annuleren</a>
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

    </script>
@endsection

