@extends('layouts.template')
@section('css_after')
    <style>
        ul {
            list-style-type: none;
        }
    </style>
@endsection
@section('main')
{{--    html code voor het aanmaken van een nieuwe user--}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Gebruiker aanmaken</h3></div>
                    <div class="card-body">
                        <form class="text-right" method="post" action="/admin/users/create/store">
                            @CSRF
                            <div class="form-group row">
                                <label for="firstName" class="col-sm-4 col-form-label">Voornaam</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName" name="firstName" placeholder="Voornaam" >
                                </div>
                                @error('firstName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="lastName" class="col-sm-4 col-form-label">Achternaam</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" placeholder="Achternaam" >
                                </div>
                                @error('lastName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" >
                                </div>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" >
                                </div>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="companyId" class="col-sm-4 col-form-label">CompanyId</label>
                                <div class="col-sm-8">
                                    <select name="companyId" id="companyId" class="form-control">
                                        @foreach ($companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="typeFunctie" class="col-sm-4 col-form-label">Type:</label>
                                <div class="col-sm-8">
                                <select name="typeFunctie" id="typeFunctie" class="form-control">
                                    @foreach ($types as $typeFunctie)
                                        <option value="{{$typeFunctie->id}}">{{$typeFunctie->name}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <hr>
                            <h4 align="left">privileges</h4>
{{--                            <div>--}}

{{--                                <div class="form-group row">--}}
{{--                                    <label for="Simpel" class="col-sm-4 col-form-label">Simpel</label>--}}
{{--                                    <div class="col-sm-1">--}}
{{--                                        <input type="radio"  name="privileges"  id="Simpel" onclick="Rechten()" value=1 checked>--}}
{{--                                    </div>--}}
{{--                                    <label for="geavanceerd" class="col-sm-4 col-form-label">geavanceerd</label>--}}
{{--                                    <div class="col-sm-1">--}}
{{--                                        <input type="radio" name="privileges" id="geavanceerd" onclick="Rechten()" value=2>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
                            <div class="form-group row">
                                <button type="button" class="col-12 btn btn-info" data-toggle="collapse" data-target="#rechtenTonen">privileges</button>
                                <br>
                                <div id="rechtenTonen" class="collapse">
                                    <div id="rechten" align="left">
                                        <ul>
                                            <li><input type="radio" name="type" id="admin" value='admin'> <label for="admin">Admin</label></li>
                                            <li><input type="radio" name="type" id="lokale_admin" value='lokale_admin'> <label for="lokale_admin">Lokale Admin</label></li>
                                            <li><input type="radio" name="type" id="gebruiker" value='gebruiker' checked><label for="gebruiker">Gebruiker</label></li>
                                            <li><input type="radio" name="type" id="guest" value='guest'> <label for="guest">Guest</label></li>
                                            {{--                                           <li><input type="checkbox" name="1" id="ALERT_CREATE" value='ALERT_CREATE'> <label for="ALERT_CREATE">ALERT_CREATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="2" id="ALERT_CREATE_COMPANY" value='ALERT_CREATE_COMPANY'> <label for="ALERT_CREATE_COMPANY">ALERT_CREATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="3" id="ALERT_READ" value='ALERT_READ'> <label for="ALERT_READ">ALERT_READ</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="4" id="ALERT_READ_COMPANY" value='ALERT_READ_COMPANY'> <label for="ALERT_READ_COMPANY">ALERT_READ_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="5" id="ALERT_DELETE" value='ALERT_DELETE'> <label for="ALERT_DELETE">ALERT_DELETE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="6" id="ALERT_DELETE_COMPANY" value='ALERT_DELETE_COMPANY'> <label for="ALERT_DELETE_COMPANY">ALERT_DELETE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="7" id="AUTHENTICATION_CREATE" value='AUTHENTICATION_CREATE'> <label for="AUTHENTICATION_CREATE">AUTHENTICATION_CREATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="8" id="AUTHENTICATION_CREATE_COMPANY" value='AUTHENTICATION_CREATE_COMPANY'> <label for="AUTHENTICATION_CREATE_COMPANY">AUTHENTICATION_CREATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="9" id="AUTHENTICATION_CREATE_COMPANY_OWN" value='AUTHENTICATION_CREATE_COMPANY_OWN'> <label for="AUTHENTICATION_CREATE_COMPANY_OWN">AUTHENTICATION_CREATE_COMPANY_OWN</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="10" id="AUTHENTICATION_READ" value='AUTHENTICATION_READ'> <label for="AUTHENTICATION_READ">AUTHENTICATION_READ</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="11" id="AUTHENTICATION_READ_COMPANY" value='AUTHENTICATION_READ_COMPANY'> <label for="AUTHENTICATION_READ_COMPANY">AUTHENTICATION_READ_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="12" id="AUTHENTICATION_UPDATE" value='AUTHENTICATION_UPDATE'> <label for="AUTHENTICATION_UPDATE">AUTHENTICATION_UPDATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="13" id="AUTHENTICATION_UPDATE_COMPANY" value='AUTHENTICATION_UPDATE_COMPANY'> <label for="AUTHENTICATION_UPDATE_COMPANY">AUTHENTICATION_UPDATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="14" id="AUTHENTICATION_DELETE" value='AUTHENTICATION_DELETE'> <label for="AUTHENTICATION_DELETE">AUTHENTICATION_DELETE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="15" id="AUTHENTICATION_DELETE_COMPANY" value='AUTHENTICATION_DELETE_COMPANY'> <label for="AUTHENTICATION_DELETE_COMPANY">AUTHENTICATION_DELETE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="16" id="AUTHERIZED_USER_PER_MACHINE_CREATE" value='AUTHERIZED_USER_PER_MACHINE_CREATE'> <label for="AUTHERIZED_USER_PER_MACHINE_CREATE">AUTHERIZED_USER_PER_MACHINE_CREATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="17" id="AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY" value='AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY'> <label for="AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY">AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="18" id="AUTHERIZED_USER_PER_MACHINE_READ" value='AUTHERIZED_USER_PER_MACHINE_READ'> <label for="AUTHERIZED_USER_PER_MACHINE_READ">AUTHERIZED_USER_PER_MACHINE_READ</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="19" id="guest" value='guest'> <label for="AUTHERIZED_USER_PER_MACHINE_READ_COMPANY">AUTHERIZED_USER_PER_MACHINE_READ_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="20" id="AUTHERIZED_USER_PER_MACHINE_DELETE" value='AUTHERIZED_USER_PER_MACHINE_DELETE'> <label for="AUTHERIZED_USER_PER_MACHINE_DELETE">AUTHERIZED_USER_PER_MACHINE_DELETE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="21" id="AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY" value='AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY'> <label for="AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY">AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="22" id="COMPANY_CREATE" value='COMPANY_CREATE'> <label for="COMPANY_CREATE">COMPANY_CREATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="23" id="COMPANY_READ" value='COMPANY_READ'> <label for="COMPANY_READ">COMPANY_READ</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="24" id="COMPANY_UPDATE" value='COMPANY_UPDATE'> <label for="COMPANY_UPDATE">COMPANY_UPDATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="25" id="COMPANY_UPDATE_COMPANY" value='COMPANY_UPDATE_COMPANY'> <label for="COMPANY_UPDATE_COMPANY">COMPANY_UPDATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="26" id="COMPANY_DELETE" value='COMPANY_DELETE'> <label for="COMPANY_DELETE">COMPANY_DELETE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="27" id="USER_CREATE" value='USER_CREATE'> <label for="USER_CREATE">USER_CREATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="28" id="USER_CREATE_COMPANY" value='USER_CREATE_COMPANY'> <label for="USER_CREATE_COMPANY">USER_CREATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="29" id="USER_READ" value='USER_READ'> <label for="USER_READ">USER_READ</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="30" id="USER_READ_COMPANY" value='USER_READ_COMPANY'> <label for="USER_READ_COMPANY">USER_READ_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="31" id="USER_UPDATE" value='USER_UPDATE'> <label for="USER_UPDATE">USER_UPDATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="32" id="USER_UPDATE_COMPANY" value='USER_UPDATE_COMPANY'> <label for="USER_UPDATE_COMPANY">USER_UPDATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="33" id="USER_DELETE" value='USER_DELETE'> <label for="USER_DELETE">USER_DELETE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="34" id="USER_DELETE_COMPANY" value='USER_DELETE_COMPANY'> <label for="USER_DELETE_COMPANY">USER_DELETE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="35" id="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE'> <label for="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="36" id="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY'> <label for="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="37" id="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ'> <label for="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="38" id="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY'> <label for="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="39" id="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE'> <label for="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="40" id="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY'> <label for="USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="41" id="VENDING_MACHINE_CREATE" value='VENDING_MACHINE_CREATE'> <label for="VENDING_MACHINE_CREATE">VENDING_MACHINE_CREATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="42" id="VENDING_MACHINE_CREATE_COMPANY" value='VENDING_MACHINE_CREATE_COMPANY'> <label for="VENDING_MACHINE_CREATE_COMPANY">VENDING_MACHINE_CREATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="43" id="VENDING_MACHINE_READ" value='VENDING_MACHINE_READ'> <label for="VENDING_MACHINE_READ">VENDING_MACHINE_READ</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="44" id="VENDING_MACHINE_READ_COMPANY" value='VENDING_MACHINE_READ_COMPANY'> <label for="VENDING_MACHINE_READ_COMPANY">VENDING_MACHINE_READ_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="45" id="VENDING_MACHINE_UPDATE" value='VENDING_MACHINE_UPDATE'> <label for="VENDING_MACHINE_UPDATE">VENDING_MACHINE_UPDATE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="46" id="VENDING_MACHINE_UPDATE_COMPANY" value='VENDING_MACHINE_UPDATE_COMPANY'> <label for="VENDING_MACHINE_UPDATE_COMPANY">VENDING_MACHINE_UPDATE_COMPANY</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="47" id="VENDING_MACHINE_DELETE" value='VENDING_MACHINE_DELETE'> <label for="VENDING_MACHINE_DELETE">VENDING_MACHINE_DELETE</label></li>--}}
                                            {{--                                           <li><input type="checkbox" name="48" id="VENDING_MACHINE_DELETE_COMPANY" value='VENDING_MACHINE_DELETE_COMPANY'> <label for="VENDING_MACHINE_DELETE_COMPANY">VENDING_MACHINE_DELETE_COMPANY</label></li>--}}
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
        // function Rechten() {
        //
        //     if (document.getElementById("Simpel").checked){
        //         document.getElementById("rechten").innerHTML = "<ul>\n" +
        //             "                                           <li><input type=\"radio\" name=\"type\" id=\"adminrechten\" value='admin'> <label for=\"adminrechten\">Admin</label></li>\n" +
        //             "                                           <li><input type=\"radio\" name=\"type\" id=\"lokale_admin\" value='lokale_admin'> <label for=\"lokale_admin\">Lokale Admin</label></li>\n" +
        //             "                                           <li><input type=\"radio\" name=\"type\" id=\"gebruiker\" value='gebruiker' checked> <label for=\"gebruiker\">Gebruiker</label></li>\n" +
        //             "                                           <li><input type=\"radio\" name=\"type\" id=\"guest\" value='guest'> <label for=\"guest\">Guest</label></li>\n" +
        //             "                                       </ul>";
        //     } else if (document.getElementById("geavanceerd").checked){
        //         document.getElementById("rechten").innerHTML = "  <ul>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"1\" id=\"ALERT_CREATE\" value='ALERT_CREATE'> <label for=\"ALERT_CREATE\">ALERT_CREATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"2\" id=\"ALERT_CREATE_COMPANY\" value='ALERT_CREATE_COMPANY'> <label for=\"ALERT_CREATE_COMPANY\">ALERT_CREATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"3\" id=\"ALERT_READ\" value='ALERT_READ'> <label for=\"ALERT_READ\">ALERT_READ</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"4\" id=\"ALERT_READ_COMPANY\" value='ALERT_READ_COMPANY'> <label for=\"ALERT_READ_COMPANY\">ALERT_READ_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"5\" id=\"ALERT_DELETE\" value='ALERT_DELETE'> <label for=\"ALERT_DELETE\">ALERT_DELETE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"6\" id=\"ALERT_DELETE_COMPANY\" value='ALERT_DELETE_COMPANY'> <label for=\"ALERT_DELETE_COMPANY\">ALERT_DELETE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"7\" id=\"AUTHENTICATION_CREATE\" value='AUTHENTICATION_CREATE'> <label for=\"AUTHENTICATION_CREATE\">AUTHENTICATION_CREATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"8\" id=\"AUTHENTICATION_CREATE_COMPANY\" value='AUTHENTICATION_CREATE_COMPANY'> <label for=\"AUTHENTICATION_CREATE_COMPANY\">AUTHENTICATION_CREATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"9\" id=\"AUTHENTICATION_CREATE_COMPANY_OWN\" value='AUTHENTICATION_CREATE_COMPANY_OWN' checked> <label for=\"AUTHENTICATION_CREATE_COMPANY_OWN\">AUTHENTICATION_CREATE_COMPANY_OWN</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"10\" id=\"AUTHENTICATION_READ\" value='AUTHENTICATION_READ'> <label for=\"AUTHENTICATION_READ\">AUTHENTICATION_READ</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"11\" id=\"AUTHENTICATION_READ_COMPANY\" value='AUTHENTICATION_READ_COMPANY'> <label for=\"AUTHENTICATION_READ_COMPANY\">AUTHENTICATION_READ_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"12\" id=\"AUTHENTICATION_UPDATE\" value='AUTHENTICATION_UPDATE'> <label for=\"AUTHENTICATION_UPDATE\">AUTHENTICATION_UPDATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"13\" id=\"AUTHENTICATION_UPDATE_COMPANY\" value='AUTHENTICATION_UPDATE_COMPANY'> <label for=\"AUTHENTICATION_UPDATE_COMPANY\">AUTHENTICATION_UPDATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"14\" id=\"AUTHENTICATION_DELETE\" value='AUTHENTICATION_DELETE'> <label for=\"AUTHENTICATION_DELETE\">AUTHENTICATION_DELETE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"15\" id=\"AUTHENTICATION_DELETE_COMPANY\" value='AUTHENTICATION_DELETE_COMPANY'> <label for=\"AUTHENTICATION_DELETE_COMPANY\">AUTHENTICATION_DELETE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"16\" id=\"AUTHERIZED_USER_PER_MACHINE_CREATE\" value='AUTHERIZED_USER_PER_MACHINE_CREATE'> <label for=\"AUTHERIZED_USER_PER_MACHINE_CREATE\">AUTHERIZED_USER_PER_MACHINE_CREATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"17\" id=\"AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY\" value='AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY'> <label for=\"AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY\">AUTHERIZED_USER_PER_MACHINE_CREATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"18\" id=\"AUTHERIZED_USER_PER_MACHINE_READ\" value='AUTHERIZED_USER_PER_MACHINE_READ'> <label for=\"AUTHERIZED_USER_PER_MACHINE_READ\">AUTHERIZED_USER_PER_MACHINE_READ</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"19\" id=\"guest\" value='guest'> <label for=\"AUTHERIZED_USER_PER_MACHINE_READ_COMPANY\">AUTHERIZED_USER_PER_MACHINE_READ_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"20\" id=\"AUTHERIZED_USER_PER_MACHINE_DELETE\" value='AUTHERIZED_USER_PER_MACHINE_DELETE'> <label for=\"AUTHERIZED_USER_PER_MACHINE_DELETE\">AUTHERIZED_USER_PER_MACHINE_DELETE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"21\" id=\"AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY\" value='AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY'> <label for=\"AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY\">AUTHERIZED_USER_PER_MACHINE_DELETE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"22\" id=\"COMPANY_CREATE\" value='COMPANY_CREATE'> <label for=\"COMPANY_CREATE\">COMPANY_CREATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"23\" id=\"COMPANY_READ\" value='COMPANY_READ'> <label for=\"COMPANY_READ\">COMPANY_READ</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"24\" id=\"COMPANY_UPDATE\" value='COMPANY_UPDATE'> <label for=\"COMPANY_UPDATE\">COMPANY_UPDATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"25\" id=\"COMPANY_UPDATE_COMPANY\" value='COMPANY_UPDATE_COMPANY'> <label for=\"COMPANY_UPDATE_COMPANY\">COMPANY_UPDATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"26\" id=\"COMPANY_DELETE\" value='COMPANY_DELETE'> <label for=\"COMPANY_DELETE\">COMPANY_DELETE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"27\" id=\"USER_CREATE\" value='USER_CREATE'> <label for=\"USER_CREATE\">USER_CREATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"28\" id=\"USER_CREATE_COMPANY\" value='USER_CREATE_COMPANY'> <label for=\"USER_CREATE_COMPANY\">USER_CREATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"29\" id=\"USER_READ\" value='USER_READ'> <label for=\"USER_READ\">USER_READ</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"30\" id=\"USER_READ_COMPANY\" value='USER_READ_COMPANY'> <label for=\"USER_READ_COMPANY\">USER_READ_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"31\" id=\"USER_UPDATE\" value='USER_UPDATE'> <label for=\"USER_UPDATE\">USER_UPDATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"32\" id=\"USER_UPDATE_COMPANY\" value='USER_UPDATE_COMPANY'> <label for=\"USER_UPDATE_COMPANY\">USER_UPDATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"33\" id=\"USER_DELETE\" value='USER_DELETE'> <label for=\"USER_DELETE\">USER_DELETE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"34\" id=\"USER_DELETE_COMPANY\" value='USER_DELETE_COMPANY'> <label for=\"USER_DELETE_COMPANY\">USER_DELETE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"35\" id=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE\" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE'> <label for=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE\">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"36\" id=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY\" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY'> <label for=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY\">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_CREATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"37\" id=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ\" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ'> <label for=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ\">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"38\" id=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY\" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY'> <label for=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY\">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_READ_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"39\" id=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE\" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE'> <label for=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE\">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"40\" id=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY\" value='USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY'> <label for=\"USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY\">USER_THAT_RECEIVE_ALERTS_FROM_VENDING_MACHINE_DELETE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"41\" id=\"VENDING_MACHINE_CREATE\" value='VENDING_MACHINE_CREATE'> <label for=\"VENDING_MACHINE_CREATE\">VENDING_MACHINE_CREATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"42\" id=\"VENDING_MACHINE_CREATE_COMPANY\" value='VENDING_MACHINE_CREATE_COMPANY'> <label for=\"VENDING_MACHINE_CREATE_COMPANY\">VENDING_MACHINE_CREATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"43\" id=\"VENDING_MACHINE_READ\" value='VENDING_MACHINE_READ'> <label for=\"VENDING_MACHINE_READ\">VENDING_MACHINE_READ</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"44\" id=\"VENDING_MACHINE_READ_COMPANY\" value='VENDING_MACHINE_READ_COMPANY'> <label for=\"VENDING_MACHINE_READ_COMPANY\">VENDING_MACHINE_READ_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"45\" id=\"VENDING_MACHINE_UPDATE\" value='VENDING_MACHINE_UPDATE'> <label for=\"VENDING_MACHINE_UPDATE\">VENDING_MACHINE_UPDATE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"46\" id=\"VENDING_MACHINE_UPDATE_COMPANY\" value='VENDING_MACHINE_UPDATE_COMPANY'> <label for=\"VENDING_MACHINE_UPDATE_COMPANY\">VENDING_MACHINE_UPDATE_COMPANY</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"47\" id=\"VENDING_MACHINE_DELETE\" value='VENDING_MACHINE_DELETE'> <label for=\"VENDING_MACHINE_DELETE\">VENDING_MACHINE_DELETE</label></li>\n" +
        //             "                                           <li><input type=\"checkbox\" name=\"48\" id=\"VENDING_MACHINE_DELETE_COMPANY\" value='VENDING_MACHINE_DELETE_COMPANY'> <label for=\"VENDING_MACHINE_DELETE_COMPANY\">VENDING_MACHINE_DELETE_COMPANY</label></li>\n" +
        //             "                                       </ul>";
        //     }
        // }
    </script>
@endsection

