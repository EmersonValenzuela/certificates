<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/correo', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');




Route::controller(CertificateController::class)->group(function ($route) {

    Route::get('/Cursos', 'index')->name('certficate.index');
    Route::get('/Generar_Certificados', 'create')->name('certficate.create');
    Route::post('/scopeData', 'store');
});

Route::controller(CourseController::class)->group(function ($route) {
    Route::get('/Curso/{course_id}', 'index');
    Route::post('/Curso/mailStudent', 'sendMail');
    Route::post('/Curso/newStudent', 'create');
    Route::post('/Curso/updateStudent', 'update');
    Route::post('/Curso/scopeStudent', 'show');
});


// Test Routes
Route::get('/generatePdf', [PdfController::class, 'generatePdf']);
Route::get('/generateqr/{data}', [QrCodeController::class, 'generarQRTransparente']);
Route::get('/verpdfs', [PdfController::class, 'index']);
