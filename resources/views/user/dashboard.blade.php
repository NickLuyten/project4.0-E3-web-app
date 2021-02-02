@extends('layouts.template')

@php
    $permissions = explode(';', Cookie::get('UserPermissions'));
@endphp

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                <div class="card">
                    <div class="card-header">Welkom {{ request()->cookie('UserFirstName')}}.</div>

                    <div class="card-body">
                        <a class="btn btn-block btn-outline-primary" href="/user/token">QR code @if(True and request()->cookie('guest') != true) aanvragen @else tonen @endif <i class="fas fa-arrow-right"></i></a>

                        @if(in_array('USER_CREATE', $permissions) or in_array('USER_CREATE_COMPANY', $permissions)) {{--cookies voor rechten binnemhalen--}}
                        <a class="btn btn-block btn-outline-primary" href="/admin/users">Gebruikers beheren <i class="fas fa-arrow-right"></i></a> {{--id = company id = TBD--}}
                        @endif

                        @if(in_array('VENDING_MACHINE_READ_COMPANY', $permissions) and request()->cookie('UserCompanyId') != null) {{--cookies voor rechten binnemhalen--}}
                        <a class="btn btn-block btn-outline-primary" href="/admin/{{ request()->cookie('UserCompanyId')}}/units">Automaten beheren <i class="fas fa-arrow-right"></i></a> {{--id = company id = TBD--}}
                        @endif

                        @if(in_array('COMPANY_READ', $permissions)) {{--cookies voor rechten binnemhalen--}}
                        <a class="btn btn-block btn-outline-primary" href="/admin/companies">Bedrijven beheren <i class="fas fa-arrow-right"></i></a> {{--enkel VanRoey admin--}}
                        @endif

                        @if(request()->cookie('UserCompanyId') != null) {{--cookies voor rechten binnemhalen--}}
                        <a class="btn btn-block btn-outline-primary" href="/admin/companies/view/{{ request()->cookie('UserCompanyId')}}">Mijn bedrijf bekijken <i class="fas fa-arrow-right"></i></a> {{--enkel VanRoey admin--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
