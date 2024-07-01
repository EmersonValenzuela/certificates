<?php

namespace App\Http\Controllers;

use App\Mail\StudentMail;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CertificateController;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($course_id)
    {
        $course = Course::findOrFail($course_id);
        $students = Student::where('course_id', $course_id)->get();
        $students_count = $students->count();

        $title = "Curso";
        return view('course.index',  compact('title', 'course', 'students', 'students_count'));
    }

    public function sendMail(Request $request)
    {
        $code = $request->input('code');

        $student = Student::where('code_student', $code)->first();

        if (!$student) {
            return response()->json(['success' => false, 'icon' => 'error', 'message' => 'Correo No Enviado']);
        }

        $mail = $request->input('mail');

        try {
            Mail::to($mail)->send(new StudentMail($student));

            $student->status_mail = 1;
            $student->save();

            return response()->json(['success' => true, 'icon' => 'success', 'message' => 'Correo Enviado']);
        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante el envío del correo
            return response()->json(['mail' => 'Error al enviar el correo electrónico: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, CertificateController $certificateController)
    {
        DB::beginTransaction();

        try {
            $student = new Student();
            $student->course_id = $request->input('courseId');
            $student->code_student = $request->input('codeForm');
            $student->cip_student = $request->input('cipForm');
            $student->course_student = $request->input('courseName');
            $student->name_student = $request->input('nameForm');
            $student->score_student = $request->input('scoreForm');
            $student->email_student = $request->input('mailForm');
            $student->url_student = $request->input('linkForm');
            $student->save();


            $img1Url = Storage::url($request->input('file1'));
            $img2Url = Storage::url($request->input('file2'));

            // Llama al método generatePdf del controlador CertificateController
            $certificateController->generatePdf($img1Url, $img2Url, $student->url_student, $student);

            // Confirmar la transacción
            DB::commit();

            // Redireccionar o devolver una respuesta JSON u otra lógica de respuesta según tu aplicación
            return response()->json(['success' => true, 'icon' => 'success', 'message' => 'Ingreso de Estudiante Exitoso.']);
        } catch (\Illuminate\Database\QueryException $e) {
            // Si hay un error de duplicado, deshacer la transacción
            DB::rollBack();

            if ($e->errorInfo[1] == 1062) {
                // Código de error 1062 es para duplicados en MySQL
                return response()->json(['success' => false, 'icon' => 'error', 'message' => 'El código de estudiante ya existe.']);
            }

            // Devolver un mensaje de error genérico
            return response()->json(['success' => false, 'icon' => 'error', 'message' => 'Error al ingresar a estudiante: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            // Si hay cualquier otro error, deshacer la transacción
            DB::rollBack();

            // Devolver un mensaje de error genérico
            return response()->json(['success' => false, 'icon' => 'error', 'message' => 'Error al ingresar a estudiante: ' . $e->getMessage()]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $idStudent = $request->get('idStudent');

        // Busca el estudiante por ID
        $student = Student::find($idStudent);

        if ($student) {
            return response()->json($student);
        } else {
            return response()->json(['error' => 'Estudiante no encontrado'], 404);
        }
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
    public function update(Request $request, CertificateController $certificateController)
    {
        DB::beginTransaction();

        try {
            // Buscar al estudiante por ID
            $student = Student::findOrFail($request->input('inputStudent'));

            // Actualizar los campos del estudiante
            $student->course_id = $request->input('courseId');
            $student->code_student = $request->input('codeForm');
            $student->cip_student = $request->input('cipForm');
            $student->course_student = $request->input('courseName');
            $student->name_student = $request->input('nameForm');
            $student->score_student = $request->input('scoreForm');
            $student->email_student = $request->input('mailForm');
            $student->url_student = $request->input('linkForm');
            $student->save();

            $img1Url = Storage::url($request->input('file1'));
            $img2Url = Storage::url($request->input('file2'));

            // Llama al método generatePdf del controlador CertificateController
            $certificateController->generatePdf($img1Url, $img2Url, $student->url_student, $student);

            // Confirmar la transacción
            DB::commit();

            // Redireccionar o devolver una respuesta JSON u otra lógica de respuesta según tu aplicación
            return response()->json(['success' => true, 'icon' => 'success', 'message' => 'Actualización de Estudiante Exitosa.']);
        } catch (\Illuminate\Database\QueryException $e) {
            // Si hay un error de duplicado, deshacer la transacción
            DB::rollBack();

            if ($e->errorInfo[1] == 1062) {
                // Código de error 1062 es para duplicados en MySQL
                return response()->json(['success' => false, 'icon' => 'error', 'message' => 'El código de estudiante ya existe.']);
            }

            // Devolver un mensaje de error genérico
            return response()->json(['success' => false, 'icon' => 'error', 'message' => 'Error al actualizar al estudiante: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            // Si hay cualquier otro error, deshacer la transacción
            DB::rollBack();

            // Devolver un mensaje de error genérico
            return response()->json(['success' => false, 'icon' => 'error', 'message' => 'Error al actualizar al estudiante: ' . $e->getMessage()]);
        }
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
