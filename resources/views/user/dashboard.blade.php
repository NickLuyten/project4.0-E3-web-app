@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{$errors->first()}}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Welkom {{$name}}.</div>

                    <div class="card-body">
                        <a class="btn btn-block btn-outline-primary" href="/user/token">QR code aanvragen <i class="fas fa-arrow-right"></i></a>

                        @if(True) {{--cookies voor rechten binnemhalen--}}
                        <a class="btn btn-block btn-outline-primary" href="/admin/id/users">Gebruikers beheren <i class="fas fa-arrow-right"></i></a> {{--id = company id = TBD--}}
                        @endif

                        @if(True) {{--cookies voor rechten binnemhalen--}}
                        <a class="btn btn-block btn-outline-primary" href="/admin/1/units">Machines beheren <i class="fas fa-arrow-right"></i></a> {{--id = company id = TBD--}}
                        @endif

                        @if(True) {{--cookies voor rechten binnemhalen--}}
                        <a class="btn btn-block btn-outline-primary" href="/admin/id/access">Toegang beheren <i class="fas fa-arrow-right"></i></a> {{--id = company id = TBD--}}
                        @endif

                        @if(True) {{--cookies voor rechten binnemhalen--}}
                        <a class="btn btn-block btn-outline-primary" href="/admin/companies">Bedrijven beheren <i class="fas fa-arrow-right"></i></a> {{--enkel VanRoey admin--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
