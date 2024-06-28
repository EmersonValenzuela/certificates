<?php

namespace App\Http\Controllers;

use App\Mail\StudentMail;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    public function create()
    {
        //
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
