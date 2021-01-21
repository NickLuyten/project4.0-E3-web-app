@extends('layouts.template')

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Jouw QR code.</div>

                    <div class="card-body">
                        <div id="qrcode" class="d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_after')
    <script src="js/qrcode.min.js"></script>

    <script type="text/javascript">
        new QRCode(document.getElementById("qrcode"), '{{$hash}}');
    </script>

@endsection
