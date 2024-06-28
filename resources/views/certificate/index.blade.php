@extends('layouts/layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">


        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Certificados /</span> Cursos
        </h4>
        <div class="row g-4">
            <div class="col-xl-5 col-lg-6 col-md-6">
                <div class="faq-header d-flex flex-column justify-content-center align-items-center mb-3">
                    <div class="input-wrapper my-3 input-group input-group-lg input-group-merge px-5">
                        <span class="input-group-text" id="basic-addon1"><i class="mdi mdi-magnify mdi-20px"></i></span>
                        <input type="text" class="form-control" id="searchCourse" placeholder="Buscar curso..."
                            aria-label="Buscar curso">


                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4" id="courseList">
            @foreach ($courses as $course)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <a href="{{ url('Curso/' . $course->id_course) }}" class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <img src="{{ asset('img/icons/brands/support-label.png') }}" alt="Avatar"
                                            class="rounded-circle">
                                    </div>
                                    <div class="me-2 text-heading h5 mb-0">
                                        {{ $course->name_course }}
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex align-items-center flex-wrap">
                                <div class="px-2 py-1 rounded-2 me-auto mb-3">

                                </div>
                                <div class="text-end mb-3">
                                    <p class="mb-1">
                                        <span class="text-heading fw-medium">Registro: </span>
                                        <span>{{ $course->dateFinish }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-body">Correos Enviados: {{ $course->students_sent_count }}</small>
                                <small class="text-body">Correos <b>No</b> Enviados:
                                    {{ $course->students_not_sent_count }}</small>
                            </div>
                            @php
                                $totalStudents = $course->students_count;
                                $sentPercentage =
                                    $totalStudents > 0 ? ($course->students_sent_count / $totalStudents) * 100 : 0;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-body">Correos:
                                    {{ $course->students_sent_count }}/{{ $totalStudents }}</small>
                                <small class="text-body">{{ round($sentPercentage, 2) }}% Enviados</small>
                            </div>
                            <div class="progress mb-3 rounded" style="height: 8px;">
                                <div class="progress-bar rounded" role="progressbar" style="width: {{ $sentPercentage }}%;"
                                    aria-valuenow="{{ $sentPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 z-2">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            title="" class="avatar avatar-sm pull-up">
                                            <img class="rounded-circle" src="{{ asset('img/avatars/5.png') }}"
                                                alt="Avatar">
                                        </li>
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            title="" class="avatar avatar-sm pull-up">
                                            <img class="rounded-circle" src="{{ asset('img/avatars/12.png') }}"
                                                alt="Avatar">
                                        </li>
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            title="" class="avatar avatar-sm pull-up me-2">
                                            <img class="rounded-circle" src="{{ asset('img/avatars/6.png') }}"
                                                alt="Avatar">
                                        </li>
                                        <li><small class="text-muted">{{ $course->students_count }} Estudiantes</small>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <!-- Content -->
@endsection()

@section('styles')
    <script></script>
@endsection()

@section('scripts')
    <script>
        $('#searchCourse').on('input', function() {
            var searchValue = $(this).val().toLowerCase().trim();

            $('#courseList .card').each(function() {
                var courseName = $(this).find('.text-heading').text().toLowerCase();

                if (courseName.includes(searchValue)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        });
    </script>
@endsection
