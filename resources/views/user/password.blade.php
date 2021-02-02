@extends('layouts.template')

@section('title', 'Update password')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('shared.alert')
                <div class="card">

                    <div class="card-header"><h3>Nieuw wachtwoord instellen</h3></div>
                    <div class="card-body">
                        <form class="text-right" method="post" action="/profile/password/update">
                            @CSRF
                            <div class="form-group row">
                                <label for="newPassword" class="col-sm-4 col-form-label">Nieuw wachtwoord</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('newPassword') is-invalid @enderror" id="newPassword" name="newPassword" placeholder="Nieuw wachtwoord" value="">
                                </div>
                                @error('newPassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="newPasswordConfirm" class="col-sm-4 col-form-label">Nieuw wachtwoord confirm</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('newPasswordConfirm') is-invalid @enderror" id="newPasswordConfirm" name="newPasswordConfirm" placeholder="Nieuw wachtwoord confirm" value="">
                                </div>
                                @error('newPasswordConfirm')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Opslaan</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
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
