@extends('layouts/layout')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="user-profile-header-banner">
                        <img src="{{ Storage::url($course->templateOne) }}" alt="Banner image" class="rounded-top">
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                        <div class="flex-grow-1 mt-3 mt-sm-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4>{{ $course->name_course }}</h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                        <li class="list-inline-item d-flex align-items-center">
                                            <i class='mdi mdi-calendar-month me-1 mdi-20px'></i><span
                                                class="fw-medium">Fecha Registro: {{ $course->dateFinish }}</span>
                                        </li>
                                        <li class="list-inline-item d-flex align-items-center">
                                            <i class="mdi mdi-account-group me-1 mdi-20px"></i>
                                            <span class="fw-medium">Estudiantes: {{ $students_count }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-primary">
                                    <i class='mdi mdi-account-check-outline me-1'></i>Connected
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->


        <div class="row mb-4 g-4">
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="pt-3">
                            <div class="row g-2 align-items-center ">
                                <div class="col-sm-12 col-lg-4">
                                    <div class="form-floating form-floating-outline me-3">
                                        <input type="text" id="referralLink" name="referralLink" class="form-control"
                                            placeholder="Nombre / Código">
                                        <label class="mb-0" for="referralLink">Buscar Estudiante</label>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-lg-4 ps-1 ps-sm-0 text-end">
                                    <div class="d-flex gap-3">
                                        <button type="button" class="btn btn-primary btn-lg btn-icon"><i
                                                class='mdi mdi-file-search-outline text-white mdi-24px'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- User Profile Content -->
        <div class="row">
            <div class="col-12 col-lg-12 mb-4 mb-xl-0">
                <div class="demo-inline-spacing mt-3">
                    <div class="list-group">
                        @foreach ($students as $student)
                            <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer">
                                <img src="{{ asset('img/avatars/5.png') }}" alt="User Image"
                                    class="rounded-circle me-3 w-px-50">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between">
                                        <div class="user-info">
                                            <h6 class="mb-1">{{ $student->name_student }}</h6>
                                            <div class="d-flex align-items-center">
                                                <div class="user-status me-2 d-flex align-items-center">
                                                    <small class="text-light">{{ $student->code_student }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-btn">
                                            <button class="btn btn-danger">
                                                <i class="mdi mdi-file-pdf-box me-1 mdi-20px"></i> Descargar PDF</button>
                                            &nbsp;
                                            <button class="btn btn-primary">
                                                <i class="mdi mdi-email-arrow-right-outline me-1 mdi-20px"></i>
                                                Enviar Correo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!--/ User Profile Content -->

    </div>
    <!-- / Content -->
@endsection()

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/css/pages/page-profile.css') }}">
@endsection()

@section('scripts')
@endsection
