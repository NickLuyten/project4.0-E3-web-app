@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Toegang tot automaat bewerken</h3></div>
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


                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Naam</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Toegang</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($CompanyUsers as $CompanyUser)
                                <tr>
                                    <th scope="row">{{$CompanyUser->id}}</th>
                                    <td>{{$CompanyUser->firstName}} {{$CompanyUser->lastName}}</td>
                                    <td>
                                        @if ($cid == $CompanyUser->companyId)
                                            intern
                                            @else
                                            <span class="badge badge-warning">extern</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form class="text-right" method="POST" action="/admin/{{$cid}}/units/{{$mid}}/access/{{$CompanyUser->id}}/store">
                                            @CSRF
                                        <input type="checkbox" name="access" onChange="this.form.submit()"
                                            @foreach ($AuthorizedUsers as $AuthorizedUser)
                                                @if ($CompanyUser->id == $AuthorizedUser->userId)
                                                    checked
                                                @endif
                                            @endforeach
                                        >
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="form-group row">
                                <div class="col">
                                    <a href="/admin/{{$cid}}/units" class="btn btn-outline-secondary">Terug</a>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
