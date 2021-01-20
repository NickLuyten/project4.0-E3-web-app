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
    <br>
    <a href="/register" class="btn btn-outline-primary btn-block"><i class="fas fa-signature"></i> Registreren</a>
    <br><br>
    <a href="/guestlogin" class="btn btn-secondary btn-block"><i class="fas fa-male"></i> Gast login</a>
</div>
@endsection
