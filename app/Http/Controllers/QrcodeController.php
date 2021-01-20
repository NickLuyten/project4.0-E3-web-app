<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelQRCode\Facades\QRCode;


class QrcodeController extends Controller
{



    public function make()
    {
        $file = public_path('assets/qr.png');
        qrcode::text('thomasmore.be')->setOutfile($file)->setSize(10)->png();
        return view('qrcode/qrcode');

    }
}
