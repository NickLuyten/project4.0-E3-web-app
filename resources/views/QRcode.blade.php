@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Jouw eenmalige QR code.</div>

                    <div class="card-body">
                        <p>{{$result->getBody()}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
