@extends('layouts.template')
@section('css_after')
    <style>
        ul {
            list-style-type: none;
        }
    </style>
@endsection
@section('main')
{{--    Editen van een user--}}
    <div class="container">
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Gebruiker {{$user->firstName}} bewerken</h3></div>
                    <div class="card-body">
                        <form class="text-right" method="post" action="/admin/users/{{$user->id}}">
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
                            @if($typePermission == "admin")
                            <div class="form-group row">
                                <label for="companyId" class="col-sm-4 col-form-label">CompanyId</label>
                                <div class="col-sm-8">
                                    <select name="companyId" id="companyId" class="form-control">

                                            @foreach ($companies as $company)
                                                <option value="{{$company->id}}" @if($user->companyId == $company->id ) selected @endif>{{$company->name}}</option>
                                            @endforeach




                                    </select>
                                </div>
                            </div>
                            @elseif ($typePermission == "lokale_admin")
                            @endif
                            {{--Checken als typeFunctie evereen komt--}}
                            <div class="form-group row">
                                <label for="typeFunctie" class="col-sm-4 col-form-label">Type:</label>
                                <div class="col-sm-8">
                                    <select name="typeFunctie" id="typeFunctie" class="form-control">
                                        @foreach ($types as $typeFunctie)
                                            <option value="{{$typeFunctie->id}}" @if($user->typeId == $typeFunctie->id ) selected @endif>{{$typeFunctie->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <h4 align="left">privileges</h4>
                            <div>

                                    <div class="form-group row">
                                        <label for="Simpel" class="col-sm-4 col-form-label">Simpel</label>
                                        <div class="col-sm-1">
                                            <input type="radio"  name="privileges"  id="Simpel" onclick="Rechten()" value=1 checked>
                                        </div>
                                        <label for="geavanceerd" class="col-sm-4 col-form-label">geavanceerd</label>
                                        <div class="col-sm-1">
                                            <input type="radio" name="privileges" id="geavanceerd" onclick="Rechten()" value=2>
                                        </div>
                                    </div>

                            </div>
                            <div class="form-group row">
                                <button type="button" class="col-12 btn btn-info" data-toggle="collapse" data-target="#rechtenTonen">privileges</button>
                                <br>
                                <div id="rechtenTonen" class="collapse">
                                   <div id="rechten" align="left">
                                      <ul>
{{--                                          Checken als type evereen komt--}}
                                          <li><input type="radio" name="type" id="adminrechten" value='admin' @if ($type["admin"] == true) checked @endif ><label for="adminrechten">Admin</label></li>
                                          <li><input type="radio" name="type" id="lokale_admin" value='lokale_admin' @if ($type["lokale_admin"] == true) checked @endif > <label for="lokale_admin" >Lokale Admin</label></li>
                                          <li><input type="radio" name="type" id="gebruiker" value='gebruiker' @if ($type["gebruiker"] == true) checked @endif > <label for="gebruiker">Gebruiker</label></li>
                                          <li><input type="radio" name="type" id="guest" value='guest' @if ($type["guest"] == true) checked @endif > <label for="guest">Guest</label></li>
{{--                                           <li><input type='checkbox' name='1' id='ALERT_CREATE' value='ALERT_CREATE'> <label for='ALERT_CREATE'>ALERT_CREATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='2' id='ALERT_CREATE_COMPANY' value='ALERT_CREATE_COMPANY'> <label for='ALERT_CREATE_COMPANY'>ALERT_CREATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='3' id='ALERT_READ' value='ALERT_READ'> <label for='ALERT_READ'>ALERT_READ</label></li>--}}
{{--                                           <li><input type='checkbox' name='4' id='ALERT_READ_COMPANY' value='ALERT_READ_COMPANY'> <label for='ALERT_READ_COMPANY'>ALERT_READ_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='5' id='ALERT_DELETE' value='ALERT_DELETE'> <label for='ALERT_DELETE'>ALERT_DELETE</label></li>--}}
{{--                                           <li><input type='checkbox' name='6' id='ALERT_DELETE_COMPANY' value='ALERT_DELETE_COMPANY'> <label for='ALERT_DELETE_COMPANY'>ALERT_DELETE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='7' id='AUTHENTICATION_CREATE' value='AUTHENTICATION_CREATE'> <label for='AUTHENTICATION_CREATE'>AUTHENTICATION_CREATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='8' id='AUTHENTICATION_CREATE_COMPANY' value='AUTHENTICATION_CREATE_COMPANY'> <label for='AUTHENTICATION_CREATE_COMPANY'>AUTHENTICATION_CREATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='9' id='AUTHENTICATION_CREATE_COMPANY_OWN' value='AUTHENTICATION_CREATE_COMPANY_OWN'> <label for='AUTHENTICATION_CREATE_COMPANY_OWN'>AUTHENTICATION_CREATE_COMPANY_OWN</label></li>--}}
{{--                                           <li><input type='checkbox' name='10' id='AUTHENTICATION_READ' value='AUTHENTICATION_READ'> <label for='AUTHENTICATION_READ'>AUTHENTICATION_READ</label></li>--}}
{{--                                           <li><input type='checkbox' name='11' id='AUTHENTICATION_READ_COMPANY' value='AUTHENTICATION_READ_COMPANY'> <label for='AUTHENTICATION_READ_COMPANY'>AUTHENTICATION_READ_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='12' id='AUTHENTICATION_UPDATE' value='AUTHENTICATION_UPDATE'> <label for='AUTHENTICATION_UPDATE'>AUTHENTICATION_UPDATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='13' id='AUTHENTICATION_UPDATE_COMPANY' value='AUTHENTICATION_UPDATE_COMPANY'> <label for='AUTHENTICATION_UPDATE_COMPANY'>AUTHENTICATION_UPDATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='14' id='AUTHENTICATION_DELETE' value='AUTHENTICATION_DELETE'> <label for='AUTHENTICATION_DELETE'>AUTHENTICATION_DELETE</label></li>--}}
{{--                                           <li><input type='checkbox' name='15' id='AUTHENTICATION_DELETE_COMPANY' value='AUTHENTICATION_DELETE_COMPANY'> <label for='AUTHENTICATION_DELETE_COMPANY'>AUTHENTICATION_DELETE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='16' id='AUTHERIZED_USER_PER_MACHINE_CREATE' value='AUTHERIZED_USER_PER_MACHINE_CREATE'> <label for='AUTHERIZED_USER_PER_MACHINE_CREATE'>AUTHERIZED_USER_PER_MACHINE_CREATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='17' id='AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY' value='AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY'> <label for='AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY'>AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='18' id='AUTHERIZED_USER_PER_MACHINE_READ' value='AUTHERIZED_USER_PER_MACHINE_READ'> <label for='AUTHERIZED_USER_PER_MACHINE_READ'>AUTHERIZED_USER_PER_MACHINE_READ</label></li>--}}
{{--                                           <li><input type='checkbox' name='19' id='AUTHERIZED_USER_PER_MACHINE_READ_COMPANY' value='AUTHERIZED_USER_PER_MACHINE_READ_COMPANY'> <label for='AUTHERIZED_USER_PER_MACHINE_READ_COMPANY'>AUTHERIZED_USER_PER_MACHINE_READ_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='20' id='AUTHERIZED_USER_PER_MACHINE_DELETE' value='AUTHERIZED_USER_PER_MACHINE_DELETE'> <label for='AUTHERIZED_USER_PER_MACHINE_DELETE'>AUTHERIZED_USER_PER_MACHINE_DELETE</label></li>--}}
{{--                                           <li><input type='checkbox' name='21' id='AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY' value='AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY'> <label for='AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY'>AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='22' id='COMPANY_CREATE' value='COMPANY_CREATE'> <label for='COMPANY_CREATE'>COMPANY_CREATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='23' id='COMPANY_READ' value='COMPANY_READ'> <label for='COMPANY_READ'>COMPANY_READ</label></li>--}}
{{--                                           <li><input type='checkbox' name='24' id='COMPANY_UPDATE' value='COMPANY_UPDATE'> <label for='COMPANY_UPDATE'>COMPANY_UPDATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='25' id='COMPANY_UPDATE_COMPANY' value='COMPANY_UPDATE_COMPANY'> <label for='COMPANY_UPDATE_COMPANY'>COMPANY_UPDATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='26' id='COMPANY_DELETE' value='COMPANY_DELETE'> <label for='COMPANY_DELETE'>COMPANY_DELETE</label></li>--}}
{{--                                           <li><input type='checkbox' name='27' id='USER_CREATE' value='USER_CREATE'> <label for='USER_CREATE'>USER_CREATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='28' id='USER_CREATE_COMPANY' value='USER_CREATE_COMPANY'> <label for='USER_CREATE_COMPANY'>USER_CREATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='29' id='USER_READ' value='USER_READ'> <label for='USER_READ'>USER_READ</label></li>--}}
{{--                                           <li><input type='checkbox' name='30' id='USER_READ_COMPANY' value='USER_READ_COMPANY'> <label for='USER_READ_COMPANY'>USER_READ_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='31' id='USER_UPDATE' value='USER_UPDATE'> <label for='USER_UPDATE'>USER_UPDATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='32' id='USER_UPDATE_COMPANY' value='USER_UPDATE_COMPANY'> <label for='USER_UPDATE_COMPANY'>USER_UPDATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='33' id='USER_DELETE' value='USER_DELETE'> <label for='USER_DELETE'>USER_DELETE</label></li>--}}
{{--                                           <li><input type='checkbox' name='34' id='USER_DELETE_COMPANY' value='USER_DELETE_COMPANY'> <label for='USER_DELETE_COMPANY'>USER_DELETE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='35' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE'> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='36' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY'> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='37' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ'> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ</label></li>--}}
{{--                                           <li><input type='checkbox' name='38' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY'> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='39' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE'> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE</label></li>--}}
{{--                                           <li><input type='checkbox' name='40' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY'> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='41' id='VENDING_MACHINE_CREATE' value='VENDING_MACHINE_CREATE'> <label for='VENDING_MACHINE_CREATE'>VENDING_MACHINE_CREATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='42' id='VENDING_MACHINE_CREATE_COMPANY' value='VENDING_MACHINE_CREATE_COMPANY'> <label for='VENDING_MACHINE_CREATE_COMPANY'>VENDING_MACHINE_CREATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='43' id='VENDING_MACHINE_READ' value='VENDING_MACHINE_READ'> <label for='VENDING_MACHINE_READ'>VENDING_MACHINE_READ</label></li>--}}
{{--                                           <li><input type='checkbox' name='44' id='VENDING_MACHINE_READ_COMPANY' value='VENDING_MACHINE_READ_COMPANY'> <label for='VENDING_MACHINE_READ_COMPANY'>VENDING_MACHINE_READ_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='45' id='VENDING_MACHINE_UPDATE' value='VENDING_MACHINE_UPDATE'> <label for='VENDING_MACHINE_UPDATE'>VENDING_MACHINE_UPDATE</label></li>--}}
{{--                                           <li><input type='checkbox' name='46' id='VENDING_MACHINE_UPDATE_COMPANY' value='VENDING_MACHINE_UPDATE_COMPANY'> <label for='VENDING_MACHINE_UPDATE_COMPANY'>VENDING_MACHINE_UPDATE_COMPANY</label></li>--}}
{{--                                           <li><input type='checkbox' name='47' id='VENDING_MACHINE_DELETE' value='VENDING_MACHINE_DELETE'> <label for='VENDING_MACHINE_DELETE'>VENDING_MACHINE_DELETE</label></li>--}}
{{--                                          <li><input type='checkbox' name='48' id='VENDING_MACHINE_DELETE_COMPANY' value='VENDING_MACHINE_DELETE_COMPANY'> <label for='VENDING_MACHINE_DELETE_COMPANY'>VENDING_MACHINE_DELETE_COMPANY</label></li>--}}
{{--                                          <li><input type='checkbox' name='49' id='TYPE_CREATE' value='TYPE_CREATE'> <label for='TYPE_CREATE'>TYPE_CREATE</label></li>--}}
{{--                                          <li><input type='checkbox' name='50' id='TYPE_CREATE_COMPANY' value='TYPE_CREATE_COMPANY'> <label for='TYPE_CREATE_COMPANY'>TYPE_CREATE_COMPANY</label></li>--}}
{{--                                          <li><input type='checkbox' name='51' id='TYPE_READ' value='TYPE_READ'> <label for='TYPE_READ'>TYPE_READ</label></li>--}}
{{--                                          <li><input type='checkbox' name='52' id='TYPE_READ_COMPANY' value='TYPE_READ_COMPANY'> <label for='TYPE_READ_COMPANY'>TYPE_READ_COMPANY</label></li>--}}
{{--                                          <li><input type='checkbox' name='53' id='TYPE_UPDATE' value='TYPE_UPDATE'> <label for='TYPE_UPDATE'>TYPE_UPDATE</label></li>--}}
{{--                                          <li><input type='checkbox' name='54' id='TYPE_UPDATE_COMPANY' value='TYPE_UPDATE_COMPANY'> <label for='TYPE_UPDATE_COMPANY'>TYPE_UPDATE_COMPANY</label></li>--}}
{{--                                          <li><input type='checkbox' name='55' id='TYPE_DELETE' value='TYPE_DELETE'> <label for='TYPE_DELETE'>TYPE_DELETE</label></li>--}}
{{--                                          <li><input type='checkbox' name='56' id='TYPE_DELETE_COMPANY' value='TYPE_DELETE_COMPANY'> <label for='TYPE_DELETE_COMPANY'>TYPE_DELETE_COMPANY</label></li>--}}
                                       </ul>
                                   </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Opslaan</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <a href="/admin/users" class="btn btn-outline-secondary">Annuleren</a>
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
        function Rechten() {

            if (document.getElementById("Simpel").checked){
                var admin = "<?php echo json_encode($type["admin"]) ?>";
                var lokale_admin = "<?php echo json_encode($type["lokale_admin"]) ?>";
                var gebruiker = "<?php echo json_encode($type["gebruiker"]) ?>";
                var guest = "<?php echo json_encode($type["guest"]) ?>";

                var htmlSimpel = ""
                if(admin === "true") {
                    htmlSimpel = "<ul>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"adminrechten\" value=\"admin\" checked><label for=\"adminrechten\">Admin</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"lokale_admin\" value=\"lokale_admin\"> <label for=\"lokale_admin\">Lokale Admin</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"gebruiker\" value=\"gebruiker\" > <label for=\"gebruiker\">Gebruiker</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"guest\" value=\"guest\" > <label for=\"guest\">Guest</label></li>\n" +
                        "                                       </ul>";
                } else if(lokale_admin === "true") {
                    htmlSimpel = "<ul>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"adminrechten\" value=\"admin\"><label for=\"adminrechten\">Admin</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"lokale_admin\" value=\"lokale_admin\" checked> <label for=\"lokale_admin\">Lokale Admin</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"gebruiker\" value=\"gebruiker\"> <label for=\"gebruiker\">Gebruiker</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"guest\" value=\"guest\" > <label for=\"guest\">Guest</label></li>\n" +
                        "                                       </ul>";

                } else if(gebruiker === "true") {
                    htmlSimpel = "<ul>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"adminrechten\" value=\"admin\"><label for=\"adminrechten\">Admin</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"lokale_admin\" value=\"lokale_admin\"> <label for=\"lokale_admin\">Lokale Admin</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"gebruiker\" value=\"gebruiker\" checked> <label for=\"gebruiker\">Gebruiker</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"guest\" value=\"guest\" > <label for=\"guest\">Guest</label></li>\n" +
                        "                                       </ul>";

                } else if(guest === "true") {
                    htmlSimpel = "<ul>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"adminrechten\" value=\"admin\"><label for=\"adminrechten\">Admin</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"lokale_admin\" value=\"lokale_admin\"> <label for=\"lokale_admin\">Lokale Admin</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"gebruiker\" value=\"gebruiker\"> <label for=\"gebruiker\">Gebruiker</label></li>\n" +
                        "                                           <li><input type=\"radio\" name=\"type\" id=\"guest\" value=\"guest\" checked> <label for=\"guest\">Guest</label></li>\n" +
                        "                                       </ul>";
                }

                document.getElementById("rechten").innerHTML = htmlSimpel;

            } else if (document.getElementById("geavanceerd").checked){
                var i;
                document.getElementById("rechten").innerHTML = "                                      <ul>\n" +
                    "                                           <li><input type='checkbox' name='1' id='ALERT_CREATE' value='ALERT_CREATE'\"+ @foreach($user->permissions as $permission) @if($permission == "ALERT_CREATE") checked @else @endif @endforeach +\"> <label for='ALERT_CREATE'>ALERT_CREATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='2' id='ALERT_CREATE_COMPANY' value='ALERT_CREATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "ALERT_CREATE_COMPANY") checked @else @endif @endforeach +\"> <label for='ALERT_CREATE_COMPANY'>ALERT_CREATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='3' id='ALERT_READ' value='ALERT_READ' \"+ @foreach($user->permissions as $permission) @if($permission == "ALERT_READ") checked @else @endif @endforeach +\"> <label for='ALERT_READ'>ALERT_READ</label></li>\n" +
                    "                                           <li><input type='checkbox' name='4' id='ALERT_READ_COMPANY' value='ALERT_READ_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "ALERT_READ_COMPANY") checked @else @endif @endforeach +\"> <label for='ALERT_READ_COMPANY'>ALERT_READ_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='5' id='ALERT_DELETE' value='ALERT_DELETE' \"+ @foreach($user->permissions as $permission) @if($permission == "ALERT_DELETE") checked @else @endif @endforeach +\"> <label for='ALERT_DELETE'>ALERT_DELETE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='6' id='ALERT_DELETE_COMPANY' value='ALERT_DELETE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "ALERT_DELETE_COMPANY") checked @else @endif @endforeach +\"> <label for='ALERT_DELETE_COMPANY'>ALERT_DELETE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='7' id='AUTHENTICATION_CREATE' value='AUTHENTICATION_CREATE' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHENTICATION_CREATE") checked @else @endif @endforeach +\"> <label for='AUTHENTICATION_CREATE'>AUTHENTICATION_CREATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='8' id='AUTHENTICATION_CREATE_COMPANY' value='AUTHENTICATION_CREATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHENTICATION_CREATE_COMPANY") checked @else @endif @endforeach +\"> <label for='AUTHENTICATION_CREATE_COMPANY'>AUTHENTICATION_CREATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='9' id='AUTHENTICATION_CREATE_COMPANY_OWN' value='AUTHENTICATION_CREATE_COMPANY_OWN' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHENTICATION_CREATE_COMPANY_OWN") checked @else @endif @endforeach +\"> <label for='AUTHENTICATION_CREATE_COMPANY_OWN'>AUTHENTICATION_CREATE_COMPANY_OWN</label></li>\n" +
                    "                                           <li><input type='checkbox' name='10' id='AUTHENTICATION_READ' value='AUTHENTICATION_READ' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHENTICATION_READ") checked @else @endif @endforeach +\"> <label for='AUTHENTICATION_READ'>AUTHENTICATION_READ</label></li>\n" +
                    "                                           <li><input type='checkbox' name='11' id='AUTHENTICATION_READ_COMPANY' value='AUTHENTICATION_READ_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHENTICATION_READ_COMPANY") checked @else @endif @endforeach +\"> <label for='AUTHENTICATION_READ_COMPANY'>AUTHENTICATION_READ_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='12' id='AUTHENTICATION_UPDATE' value='AUTHENTICATION_UPDATE' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHENTICATION_UPDATE") checked @else @endif @endforeach +\"> <label for='AUTHENTICATION_UPDATE'>AUTHENTICATION_UPDATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='13' id='AUTHENTICATION_UPDATE_COMPANY' value='AUTHENTICATION_UPDATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHENTICATION_UPDATE_COMPANY") checked @else @endif @endforeach +\"> <label for='AUTHENTICATION_UPDATE_COMPANY'>AUTHENTICATION_UPDATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='14' id='AUTHENTICATION_DELETE' value='AUTHENTICATION_DELETE' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHENTICATION_DELETE") checked @else @endif @endforeach +\"> <label for='AUTHENTICATION_DELETE'>AUTHENTICATION_DELETE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='15' id='AUTHENTICATION_DELETE_COMPANY' value='AUTHENTICATION_DELETE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHENTICATION_DELETE_COMPANY") checked @else @endif @endforeach +\"> <label for='AUTHENTICATION_DELETE_COMPANY'>AUTHENTICATION_DELETE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='16' id='AUTHERIZED_USER_PER_MACHINE_CREATE' value='AUTHERIZED_USER_PER_MACHINE_CREATE' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHERIZED_USER_PER_MACHINE_CREATE") checked @else @endif @endforeach +\"> <label for='AUTHERIZED_USER_PER_MACHINE_CREATE'>AUTHERIZED_USER_PER_MACHINE_CREATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='17' id='AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY' value='AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY") checked @else @endif @endforeach +\"> <label for='AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY'>AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='18' id='AUTHERIZED_USER_PER_MACHINE_READ' value='AUTHERIZED_USER_PER_MACHINE_READ' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHERIZED_USER_PER_MACHINE_READ") checked @else @endif @endforeach +\"> <label for='AUTHERIZED_USER_PER_MACHINE_READ'>AUTHERIZED_USER_PER_MACHINE_READ</label></li>\n" +
                    "                                           <li><input type='checkbox' name='19' id='AUTHERIZED_USER_PER_MACHINE_READ_COMPANY' value='AUTHERIZED_USER_PER_MACHINE_READ_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHERIZED_USER_PER_MACHINE_READ_COMPANY") checked @else @endif @endforeach +\"> <label for='AUTHERIZED_USER_PER_MACHINE_READ_COMPANY'>AUTHERIZED_USER_PER_MACHINE_READ_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='20' id='AUTHERIZED_USER_PER_MACHINE_DELETE' value='AUTHERIZED_USER_PER_MACHINE_DELETE' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHERIZED_USER_PER_MACHINE_DELETE") checked @else @endif @endforeach +\"> <label for='AUTHERIZED_USER_PER_MACHINE_DELETE'>AUTHERIZED_USER_PER_MACHINE_DELETE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='21' id='AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY' value='AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY") checked @else @endif @endforeach +\"> <label for='AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY'>AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='22' id='COMPANY_CREATE' value='COMPANY_CREATE' \"+ @foreach($user->permissions as $permission) @if($permission == "COMPANY_CREATE") checked @else @endif @endforeach +\"> <label for='COMPANY_CREATE'>COMPANY_CREATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='23' id='COMPANY_READ' value='COMPANY_READ' \"+ @foreach($user->permissions as $permission) @if($permission == "COMPANY_READ") checked @else @endif @endforeach +\"> <label for='COMPANY_READ'>COMPANY_READ</label></li>\n" +
                    "                                           <li><input type='checkbox' name='24' id='COMPANY_UPDATE' value='COMPANY_UPDATE' \"+ @foreach($user->permissions as $permission) @if($permission == "COMPANY_UPDATE") checked @else @endif @endforeach +\"> <label for='COMPANY_UPDATE'>COMPANY_UPDATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='25' id='COMPANY_UPDATE_COMPANY' value='COMPANY_UPDATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "COMPANY_UPDATE_COMPANY") checked @else @endif @endforeach +\"> <label for='COMPANY_UPDATE_COMPANY'>COMPANY_UPDATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='26' id='COMPANY_DELETE' value='COMPANY_DELETE' \"+ @foreach($user->permissions as $permission) @if($permission == "COMPANY_DELETE") checked @else @endif @endforeach +\"> <label for='COMPANY_DELETE'>COMPANY_DELETE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='27' id='USER_CREATE' value='USER_CREATE' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_CREATE") checked @else @endif @endforeach +\"> <label for='USER_CREATE'>USER_CREATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='28' id='USER_CREATE_COMPANY' value='USER_CREATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_CREATE_COMPANY") checked @else @endif @endforeach +\"> <label for='USER_CREATE_COMPANY'>USER_CREATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='29' id='USER_READ' value='USER_READ' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_READ") checked @else @endif @endforeach +\"> <label for='USER_READ'>USER_READ</label></li>\n" +
                    "                                           <li><input type='checkbox' name='30' id='USER_READ_COMPANY' value='USER_READ_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_READ_COMPANY") checked @else @endif @endforeach +\"> <label for='USER_READ_COMPANY'>USER_READ_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='31' id='USER_UPDATE' value='USER_UPDATE' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_UPDATE") checked @else @endif @endforeach +\"> <label for='USER_UPDATE'>USER_UPDATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='32' id='USER_UPDATE_COMPANY' value='USER_UPDATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_UPDATE_COMPANY") checked @else @endif @endforeach +\"> <label for='USER_UPDATE_COMPANY'>USER_UPDATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='33' id='USER_DELETE' value='USER_DELETE' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_DELETE") checked @else @endif @endforeach +\"> <label for='USER_DELETE'>USER_DELETE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='34' id='USER_DELETE_COMPANY' value='USER_DELETE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_DELETE_COMPANY") checked @else @endif @endforeach +\"> <label for='USER_DELETE_COMPANY'>USER_DELETE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='35' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE") checked @else @endif @endforeach +\"> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='36' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY") checked @else @endif @endforeach +\"> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='37' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ") checked @else @endif @endforeach +\"> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ</label></li>\n" +
                    "                                           <li><input type='checkbox' name='38' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY") checked @else @endif @endforeach +\"> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='39' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE") checked @else @endif @endforeach +\"> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='40' id='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY' value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY") checked @else @endif @endforeach +\"> <label for='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY'>USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='41' id='VENDING_MACHINE_CREATE' value='VENDING_MACHINE_CREATE' \"+ @foreach($user->permissions as $permission) @if($permission == "VENDING_MACHINE_CREATE") checked @else @endif @endforeach +\"> <label for='VENDING_MACHINE_CREATE'>VENDING_MACHINE_CREATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='42' id='VENDING_MACHINE_CREATE_COMPANY' value='VENDING_MACHINE_CREATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "VENDING_MACHINE_CREATE_COMPANY") checked @else @endif @endforeach +\"> <label for='VENDING_MACHINE_CREATE_COMPANY'>VENDING_MACHINE_CREATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='43' id='VENDING_MACHINE_READ' value='VENDING_MACHINE_READ' \"+ @foreach($user->permissions as $permission) @if($permission == "VENDING_MACHINE_READ") checked @else @endif @endforeach +\"> <label for='VENDING_MACHINE_READ'>VENDING_MACHINE_READ</label></li>\n" +
                    "                                           <li><input type='checkbox' name='44' id='VENDING_MACHINE_READ_COMPANY' value='VENDING_MACHINE_READ_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "VENDING_MACHINE_READ_COMPANY") checked @else @endif @endforeach +\"> <label for='VENDING_MACHINE_READ_COMPANY'>VENDING_MACHINE_READ_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='45' id='VENDING_MACHINE_UPDATE' value='VENDING_MACHINE_UPDATE' \"+ @foreach($user->permissions as $permission) @if($permission == "VENDING_MACHINE_UPDATE") checked @else @endif @endforeach +\"> <label for='VENDING_MACHINE_UPDATE'>VENDING_MACHINE_UPDATE</label></li>\n" +
                    "                                           <li><input type='checkbox' name='46' id='VENDING_MACHINE_UPDATE_COMPANY' value='VENDING_MACHINE_UPDATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "VENDING_MACHINE_UPDATE_COMPANY") checked @else @endif @endforeach +\"> <label for='VENDING_MACHINE_UPDATE_COMPANY'>VENDING_MACHINE_UPDATE_COMPANY</label></li>\n" +
                    "                                           <li><input type='checkbox' name='47' id='VENDING_MACHINE_DELETE' value='VENDING_MACHINE_DELETE' \"+ @foreach($user->permissions as $permission) @if($permission == "VENDING_MACHINE_DELETE") checked @else @endif @endforeach +\"> <label for='VENDING_MACHINE_DELETE'>VENDING_MACHINE_DELETE</label></li>\n" +
                    "                                          <li><input type='checkbox' name='48' id='VENDING_MACHINE_DELETE_COMPANY' value='VENDING_MACHINE_DELETE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "VENDING_MACHINE_DELETE_COMPANY") checked @else @endif @endforeach +\"> <label for='VENDING_MACHINE_DELETE_COMPANY'>VENDING_MACHINE_DELETE_COMPANY</label></li>\n" +
                    "                                          <li><input type='checkbox' name='49' id='TYPE_CREATE' value='TYPE_CREATE' \"+ @foreach($user->permissions as $permission) @if($permission == "TYPE_CREATE") checked @else @endif @endforeach +\"> <label for='TYPE_CREATE'>TYPE_CREATE</label></li>\n" +
                    "                                          <li><input type='checkbox' name='50' id='TYPE_CREATE_COMPANY' value='TYPE_CREATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "TYPE_CREATE_COMPANY") checked @else @endif @endforeach +\"> <label for='TYPE_CREATE_COMPANY'>TYPE_CREATE_COMPANY</label></li>\n" +
                    "                                          <li><input type='checkbox' name='51' id='TYPE_READ' value='TYPE_READ' \"+ @foreach($user->permissions as $permission) @if($permission == "TYPE_READ") checked @else @endif @endforeach +\"> <label for='TYPE_READ'>TYPE_READ</label></li>\n" +
                    "                                          <li><input type='checkbox' name='52' id='TYPE_READ_COMPANY' value='TYPE_READ_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "TYPE_READ_COMPANY") checked @else @endif @endforeach +\"> <label for='TYPE_READ_COMPANY'>TYPE_READ_COMPANY</label></li>\n" +
                    "                                          <li><input type='checkbox' name='53' id='TYPE_UPDATE' value='TYPE_UPDATE' \"+ @foreach($user->permissions as $permission) @if($permission == "TYPE_UPDATE") checked @else @endif @endforeach +\"> <label for='TYPE_UPDATE'>TYPE_UPDATE</label></li>\n" +
                    "                                          <li><input type='checkbox' name='54' id='TYPE_UPDATE_COMPANY' value='TYPE_UPDATE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "TYPE_UPDATE_COMPANY") checked @else @endif @endforeach +\"> <label for='TYPE_UPDATE_COMPANY'>TYPE_UPDATE_COMPANY</label></li>\n" +
                    "                                          <li><input type='checkbox' name='55' id='TYPE_DELETE' value='TYPE_DELETE' \"+ @foreach($user->permissions as $permission) @if($permission == "TYPE_DELETE") checked @else @endif @endforeach +\"> <label for='TYPE_DELETE'>TYPE_DELETE</label></li>\n" +
                    "                                          <li><input type='checkbox' name='56' id='TYPE_DELETE_COMPANY' value='TYPE_DELETE_COMPANY' \"+ @foreach($user->permissions as $permission) @if($permission == "TYPE_DELETE_COMPANY") checked @else @endif @endforeach +\"> <label for='TYPE_DELETE_COMPANY'>TYPE_DELETE_COMPANY</label></li>\n" +
                    "                                       </ul>\n";
            }


        }
    </script>
@endsection

