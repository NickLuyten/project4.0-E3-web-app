@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Alarmontvanger toevoegen</h3></div>
                    <div class="card-body">
                        <form class="text-right" method="post" action="/admin/{{$cid}}/useralerts/store">
                            @CSRF
                            <div class="form-group row">
                                <label for="user" class="col-sm-4 col-form-label">Gebruiker-ID</label>
                                <div class="col-sm-8">
                                    <datalist id="User">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
                                        @endforeach
                                    </datalist>
                                    <input id="user" name="user" class="form-control" autoComplete="on" list="User"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="machine" class="col-sm-4 col-form-label">Machine-ID</label>
                                <div class="col-sm-8">
                                    <datalist id="Machines">
                                        @foreach($machines as $machine)
                                            <option value="{{$machine->id}}">{{$machine->name}}</option>
                                        @endforeach
                                    </datalist>
                                    <input id="machine" name="machine" class="form-control" autoComplete="on" list="Machines"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Toevoegen</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <a href="/admin/{{$cid}}/useralerts" class="btn btn-outline-secondary">Annuleren</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
