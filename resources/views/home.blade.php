@extends('layouts.template')
@section('title') Welkom @endsection
@section('main')
<div class="container text-center">
    <h1 class="display-5">SMART VENDING MACHINE</h1>
    <h4>CENTRAAL MANAGEMENT SYSTEEM</h4>
    <br>
    <p>Welkom op het portaal van de Smart Vendors Smart Vending Machines. Gelieve in te loggen om uw persoonlijke QR code te geneneren.</p>
    <br>
    <a href="/login" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Login</a>
    <a class="btn btn-success align-bottom" style="margin-top: 200px" href="/assets/app-release.apk" download>
        <span style="font-size: 20px"><i class="fab fa-android"></i> DOWNLOAD</span><br><span style="font-size: 14px">ANDROID .APK APP</span>
    </a>
</div>
@endsection
