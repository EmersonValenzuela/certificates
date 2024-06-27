<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

require(public_path('fpdf/fpdf.php'));

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Generar Certificados";
        return view('certificate.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        ini_set('max_execution_time', 300);
        $name = $request->input('name');

        $file1Path = $request->file('file1')->store('public/uploads');
        $file2Path = $request->file('file2')->store('public/uploads');

        $img1Url = Storage::url($file1Path);
        $img2Url = Storage::url($file2Path);

        $course = new Course([
            'name_course' => $name,
            'templateOne' => $file1Path,
            'tempalteTwo' => $file2Path,
            'dateFinish' => now(),
        ]);

        $course->save();
        $courseId = $course->id_course;

        $studentsData = json_decode($request->input('rows'), true);

        foreach ($studentsData as $studentData) {
            $student = new Student([
                'course_id' => $courseId,
                'code_student' => $studentData['code'],
                'course_student' => $studentData['course'],
                'name_student' => $studentData['names'],
                'score_student' => $studentData['score'],
            ]);

            $student->save();

            $this->generatePdf($img1Url, $img2Url, $student);
        }

        return response()->json(['success' => true, 'icon' => 'success', 'message' => 'Pdfs Generados']);
    }


    private function generatePdf($img1Path, $img2Path, $student)
    {


        $name = $student->name_student;
        $code = $student->code_student;
        $course = $student->course_student;
        $score = $student->score_student;

        $pdf = new \FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $anchoPagina = $pdf->GetPageWidth();
        $altoPagina = $pdf->GetPageHeight();

        // Página 1: Imagen y texto
        $pdf->Image(public_path($img1Path), 0, 0, $anchoPagina, $altoPagina);

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
        $pdf->Image(public_path($img2Path), 0, 0, $anchoPagina, $altoPagina);
        $pdf->SetFont('Oswald-Regular', '', 20);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(248.7, 43);
        $pdf->Cell(1, 5, $score, 0, 1, 'C');


        // Guardar el archivo PDF en una carpeta específica dentro del proyecto
        $pdfFileName = $student->code_student . '.pdf';
        $pdf->Output(public_path('pdfs/') . $pdfFileName, 'F');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
