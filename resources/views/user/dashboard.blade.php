@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Welkom {{$data->firstName}}.</div>

                    <div class="card-body">
                        <a class="btn btn-block btn-outline-primary" href="/RequestToken">QR code aanvragen <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
