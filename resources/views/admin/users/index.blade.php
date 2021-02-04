@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Gebruikers</h1>
{{--    Error/succes messages--}}
    @include('shared.alert')
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
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Email</th>
                <th>Bedrijf</th>
                <th>Afdeling</th>
                <th>Admin</th>
                <th>Guest</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)


                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->firstName }}</td>
                    <td>{{ $user->lastName }}</td>
                    <td>{{ $user->email }}</td>
{{-- Vergelijkt user companyId met alle companyId's en gebruikt dan de naam van de company en zo ook met de types--}}
                    @if($type == "admin")
                        <td>@foreach($companies as $company) @if($user->companyId == $company->id) {{$company->name}} @endif @endforeach</td>
                    @elseif ($type == "lokale_admin")
                        <td>{{$companies->name}}</td>
                    @endif
                    <td>@foreach($types as $typeFunctie) @if($user->typeId == $typeFunctie->id) {{$typeFunctie->name}} @endif @endforeach</td>
                    <td>
                        <?php
                        if (old('admin',$user->admin) == 1) {
                            echo "<b>&#10004;</b>";
                        } else {
                            echo "";
                        }
                        ?> </td>
                    <td>
                        <?php
                        if (old('guest',$user->guest) == 1) {
                            echo "<b>&#10004;</b>";
                        } else {
                            echo "";
                        }
                        ?> </td>
                    <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->email }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/admin/users/{{ $user->id }}/delete" class="btn btn-outline-danger"
                                   data-toggle="tooltip"
                                   title="Delete {{ $user->email }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>

                                @if (old('guest',$user->guest) == 1)
                                    <a href='/admin/users/qrcodeGuest/{{$user->id}}' class='btn btn-outline-primary'>Qr code</a>
                                @else

                                @endif

                            </div>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="/admin/users/create" class="btn btn-outline-success btn-lg btn-block"><i class="fas fa-plus"></i> Gebruiker toevoegen</a>
    </div>
@endsection
@section('script_after')
    <script>




    </script>
@endsection
