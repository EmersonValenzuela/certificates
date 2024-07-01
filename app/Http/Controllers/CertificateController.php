<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use nguyenary\QRCodeMonkey\QRCode;

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
        $title = "Cursos";
        $courses = Course::withCount([
            'students',
            'students as students_sent_count' => function ($query) {
                $query->where('status_mail', 1);
            },
            'students as students_not_sent_count' => function ($query) {
                $query->where('status_mail', 0);
            }
        ])->get();
        return view('certificate.index', compact('courses', 'title'));
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

        ini_set('max_execution_time', 600);
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
                'cip_student' => $studentData['dni'],
                'course_student' => $studentData['course'],
                'name_student' => $studentData['names'],
                'score_student' => $studentData['score'],
                'email_student' => $studentData['email'],
                'url_student' => $studentData['link'],
            ]);

            $student->save();

            $this->generatePdf($img1Url, $img2Url, $studentData['link'], $student);
        }

        return response()->json(['success' => true, 'icon' => 'success', 'message' => 'Pdfs Generados', 'course' => $courseId]);
    }


    public function generatePdf($img1Path, $img2Path, $link, $student)
    {

        $name = $student->name_student;
        $code = $student->code_student;
        $course = $student->course_student;
        $score = $student->score_student;

        $qr = $this->generarQRTransparente($link);

        $pdf = new \FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $anchoPagina = $pdf->GetPageWidth();
        $altoPagina = $pdf->GetPageHeight();

        $pdf->Image(public_path($img1Path), 0, 0, $anchoPagina, $altoPagina);

        $pdf->AddFont('Oswald-Regular', '', 'Oswald-VariableFont_wght.php');
        $pdf->AddFont('Oswald-Bold', '', 'Oswald-Bold.php');
        $pdf->AddFont('Oswald-Medium', '', 'Oswald-Medium.php');

        $pdf->SetFont('Oswald-Regular', '', 11);
        $pdf->SetTextColor(117, 117, 117);
        $pdf->SetXY(25.3, 30);
        $pdf->Cell(1, 35, $code, 0, 1, 'L');

        $pdf->SetFont('Oswald-Bold', '', 22);
        $pdf->SetTextColor(0, 0, 0);

        $anchoTexto = $pdf->GetStringWidth($name);
        $x = ($anchoPagina - $anchoTexto) / 2;
        $pdf->SetXY($x, 46);
        $pdf->Cell($anchoTexto, 40, utf8_decode($name), '', 1, 'C', false);

        $pdf->SetFont('Oswald-Medium', '', 22);
        $pdf->SetTextColor(0, 0, 0);

        $anchoTexto = $pdf->GetStringWidth($course);
        $x = ($anchoPagina - $anchoTexto) / 2;
        $pdf->SetXY($x, 70);
        $pdf->Cell($anchoTexto, 40, utf8_decode($course), '', 1, 'C', false);

        $pdf->Image($qr, 27.1, 161.6, 22, 22);

        $pdf->SetFont('Oswald-Regular', '', 12);
        $pdf->SetTextColor(117, 117, 117);
        $pdf->SetXY(84, 176.7);
        $pdf->Cell(1, 5, $code, 0, 1, 'L');

        $pdf->AddPage('L');
        $pdf->SetFont('times', '', 12);

        $pdf->Image(public_path($img2Path), 0, 0, $anchoPagina, $altoPagina);
        $pdf->SetFont('Oswald-Bold', '', 20);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(248.7, 43);
        $pdf->Cell(1, 5, $score, 0, 1, 'C');

        $pdf->Image($qr, 28.3, 161.4, 22, 22);

        $pdf->SetFont('Oswald-Regular', '', 12);
        $pdf->SetTextColor(117, 117, 117);
        $pdf->SetXY(84, 176.8);
        $pdf->Cell(1, 5, $code, 0, 1, 'L');

        $pdfFileName = $student->code_student . '.pdf';
        $pdf->Output(public_path('pdfs/') . $pdfFileName, 'F');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
