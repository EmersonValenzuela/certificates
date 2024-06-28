<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use nguyenary\QRCodeMonkey\QRCode;

class QrCodeController extends Controller
{
    public function generarQRTransparente($texto)
    {
        $qrcode = new QRCode($texto);

        $qrcode->setConfig([
            'bgColor' => '',
            'body' => 'circular',
            'bodyColor' => '#0277bd',
            'brf1' => [],
            'brf2' => [],
            'brf3' => [],
            'erf1' => [],
            'erf2' => [],
            'erf3' => [],
            'eye' => 'frame13',
            'eye1Color' => '#000000',
            'eye2Color' => '#000000',
            'eye3Color' => '#000000',
            'eyeBall' => 'ball14',
            'eyeBall1Color' => '#000000',
            'eyeBall2Color' => '#000000',
            'eyeBall3Color' => '#000000',
            'gradientColor1' => '#000000',
            'gradientColor2' => '#000000',
            'gradientOnEyes' => 'true',
            'gradientType' => 'linear',
        ]);
        $qrcode->setSize(80);
        $qrcode->setFileType('png');
        $imagenBase64 = $qrcode->create();

        return view('qr')->with('qr', $imagenBase64);
    }
}
