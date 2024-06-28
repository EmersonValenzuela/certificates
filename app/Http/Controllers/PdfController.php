<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use nguyenary\QRCodeMonkey\QRCode;

class PdfController extends Controller
{
    public function index()
    {
        // Obtener la lista de archivos en la carpeta public/pdfs
        $files = File::files(public_path('pdfs'));

        // Filtrar para incluir solo archivos PDF
        $pdfFiles = array_filter($files, function ($file) {
            return $file->getExtension() === 'pdf';
        });

        // Pasar los archivos a la vista
        return view('pdfs.index', compact('pdfFiles'));
    }

    public function generatePdf()
    {
        require(public_path('fpdf/fpdf.php'));


        $img1 = "images/pagina1final.png";
        $img2 = "images/pagina2final.png";
        $name = "Marlon Valenzuela Estrada";
        $code = "1745147";
        $course = "Panaderia Nuclear";
        $score = "08";
        $link = "https://institutodozer.edu.pe/";
        $qr = $this->generarQRTransparente($link);

        $pdf = new \FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $anchoPagina = $pdf->GetPageWidth();
        $altoPagina = $pdf->GetPageHeight();

        // Página 1: Imagen y texto
        $pdf->Image(public_path($img1), 0, 0, $anchoPagina, $altoPagina);

        $pdf->AddFont('Oswald-Regular', '', 'Oswald-VariableFont_wght.php');
        $pdf->AddFont('Oswald-Bold', '', 'Oswald-Bold.php');
        $pdf->AddFont('Oswald-Medium', '', 'Oswald-Medium.php');

        $pdf->SetFont('Oswald-Regular', '', 11);
        $pdf->SetTextColor(117, 117, 117);
        $pdf->SetXY(25.3, 30);
        $pdf->Cell(1, 35, $code, 0, 1, 'L');

        // Configurar para centrar el texto
        $pdf->SetFont('Oswald-Bold', '', 22);
        $pdf->SetTextColor(0, 0, 0);

        $anchoTexto = $pdf->GetStringWidth($name);
        $x = ($anchoPagina - $anchoTexto) / 2;
        $pdf->SetXY($x, 46); // Ajustar la posición vertical según sea necesario
        $pdf->Cell($anchoTexto, 40, $name, '', 1, 'C', false);

        $pdf->SetFont('Oswald-Medium', '', 22);
        $pdf->SetTextColor(0, 0, 0);

        $anchoTexto = $pdf->GetStringWidth($course);
        $x = ($anchoPagina - $anchoTexto) / 2;
        $pdf->SetXY($x, 70); // Ajustar la posición vertical según sea necesario
        $pdf->Cell($anchoTexto, 40, utf8_decode($course), '', 1, 'C', false);

        $pdf->Image($qr, 27.1, 161.6, 22, 22);

        $pdf->SetFont('Oswald-Regular', '', 12);
        $pdf->SetTextColor(117, 117, 117);
        $pdf->SetXY(84, 176.7);
        $pdf->Cell(1, 5, $code, 0, 1, 'L');

        $pdf->AddPage('L');
        $pdf->SetFont('times', '', 12);

        // Página 2: Imagen y texto
        $pdf->Image(public_path($img2), 0, 0, $anchoPagina, $altoPagina);
        $pdf->SetFont('Oswald-Bold', '', 20);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(248.7, 43);
        $pdf->Cell(1, 5, $score, 0, 1, 'C');

        $pdf->Image($qr, 28.3, 161.4, 22, 22);

        $pdf->SetFont('Oswald-Regular', '', 12);
        $pdf->SetTextColor(117, 117, 117);
        $pdf->SetXY(84, 176.8);
        $pdf->Cell(1, 5, $code, 0, 1, 'L');

        // Guardar el archivo PDF en una carpeta específica dentro del proyecto
        $pdf->Output();

        return response()->json(['message' => 'PDF generado y guardado correctamente', 'file_path' => $filePath]);
    }

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

        $qrcode->setSize(300);
        $qrcode->setFileType('png');
        $imagenBase64 = $qrcode->create();

        return $imagenBase64; // Devuelve solo la cadena base64 de la imagen
    }
}
