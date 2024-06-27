<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
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


Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
Route::get('/generatePdf', [PdfController::class, 'generatePdf']);
Route::get('/verpdfs', [PdfController::class, 'index']);


Route::controller(CertificateController::class)->group(function ($route) {

    Route::get('/Cursos', 'index')->name('certficate.index');
    Route::get('/Generar_Certificados', 'create')->name('certficate.create');
    Route::post('/scopeData', 'store');
});
