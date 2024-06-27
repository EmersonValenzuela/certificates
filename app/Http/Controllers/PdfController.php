<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

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


        $img1 = "images/page_1.png";
        $img2 = "images/page_2.png";
        $name = "Marlon Valenzuela Estrada";
        $code = "1745147";
        $course = "Panaderia Nuclear";
        $score = "08";

        $pdf = new \FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $anchoPagina = $pdf->GetPageWidth();
        $altoPagina = $pdf->GetPageHeight();

        // Página 1: Imagen y texto
        $pdf->Image(public_path($img1), 0, 0, $anchoPagina, $altoPagina);

        $pdf->AddFont('Oswald-Regular', '', 'Oswald-VariableFont_wght.php');

        $pdf->SetFont('Oswald-Regular', '', 11);
        $pdf->SetTextColor(117, 117, 117);
        $pdf->SetXY(25.3, 30);
        $pdf->Cell(1, 35, $code, 0, 1, 'L');

        // Configurar para centrar el texto
        $pdf->SetFont('Oswald-Regular', '', 22);
        $pdf->SetTextColor(0, 0, 0);

        $anchoTexto = $pdf->GetStringWidth($name);
        $x = ($anchoPagina - $anchoTexto) / 2;
        $pdf->SetXY($x, 46); // Ajustar la posición vertical según sea necesario
        $pdf->Cell($anchoTexto, 40, $name, '', 1, 'C', false);

        $pdf->SetFont('Oswald-Regular', '', 22);
        $pdf->SetTextColor(0, 0, 0);

        $anchoTexto = $pdf->GetStringWidth($course);
        $x = ($anchoPagina - $anchoTexto) / 2;
        $pdf->SetXY($x, 70); // Ajustar la posición vertical según sea necesario
        $pdf->Cell($anchoTexto, 40, utf8_decode($course), '', 1, 'C', false);

        $pdf->SetFont('Oswald-Regular', '', 12);
        $pdf->SetTextColor(117, 117, 117);
        $pdf->SetXY(244, 178.8);
        $pdf->Cell(1, 5, $code, 0, 1, 'L');

        $pdf->AddPage('L');
        $pdf->SetFont('times', '', 12);

        // Página 2: Imagen y texto
        $pdf->Image(public_path($img2), 0, 0, $anchoPagina, $altoPagina);
        $pdf->SetFont('Oswald-Regular', '', 20);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(248.7, 43);
        $pdf->Cell(1, 5, $score, 0, 1, 'C');

        $pdf->SetFont('Oswald-Regular', '', 12);
        $pdf->SetTextColor(117, 117, 117);
        $pdf->SetXY(244, 176.2);
        $pdf->Cell(1, 5, $code, 0, 1, 'L');

        // Guardar el archivo PDF en una carpeta específica dentro del proyecto
        $pdf->Output();

        return response()->json(['message' => 'PDF generado y guardado correctamente', 'file_path' => $filePath]);
    }
}
