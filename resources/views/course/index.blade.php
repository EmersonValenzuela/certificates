@extends('layouts/layout')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="user-profile-header-banner">
                        <img src="{{ asset('img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top">
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
                                    <i class='mdi mdi-account-plus me-1'></i>Agregar Estudiante
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4 g-4">
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="pt-3">
                            <div class="row g-2 align-items-center ">
                                <div class="col-sm-12 col-lg-4">
                                    <div class="form-floating form-floating-outline me-3">
                                        <input type="text" id="referralLink" name="referralLink" class="form-control"
                                            placeholder="Buscar por Nombre o Código" aria-label="Buscar estudiante">
                                        <label class="mb-0" for="referralLink">Buscar Estudiante</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 mb-4 mb-xl-0">
                <div class="demo-inline-spacing mt-3">
                    <div class="list-group" id="studentList">
                        @foreach ($students as $student)
                            <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer">
                                <img src="{{ asset('img/avatars/5.png') }}" alt="User Image"
                                    class="rounded-circle me-3 w-px-50">
                                <div class="w-100 ">
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
                                            @php
                                                $buttonClass =
                                                    $student->status_mail == 1 ? 'btn btn-success' : 'btn btn-primary';
                                            @endphp
                                            <button class="btn btn-danger mb-2"
                                                onclick="downloadPDF('{{ asset('pdfs/' . $student->code_student . '.pdf') }}', '{{ $student->code_student }}' )">
                                                <i class="mdi mdi-file-pdf-box me-1 mdi-20px"></i>
                                            </button>
                                            &nbsp;
                                            <button class="btn {{ $buttonClass }} mb-2" id="{{ $student->code_student }}"
                                                onclick="openModal({{ $student->code_student }}, '{{ $student->name_student }}', '{{ $student->email_student }}')">
                                                <i class="mdi mdi-email-arrow-right-outline me-1 mdi-20px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Modal Authentication via SMS -->
    <div class="modal fade" id="modalMail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body py-3 py-md-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="mb-2 pt-1">Enviar Correo al estudiante: </h4>
                    <p class="mb-4 text-truncate" id="student"></p>
                    <div class="mb-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-email-arrow-right fs-3"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="mailStudent" class="form-control" placeholder="example@gmail.com">
                                <label for="mailStudent">Correo Electronico</label>
                            </div>
                            <input type="hidden" id="codeStudent" name="codeStudent">
                            <span class="input-group-text cursor-pointer" id="modalAddCardCvv2">
                                <i class="mdi mdi-help-circle-outline text-muted" data-bs-toggle="tooltip"
                                    data-bs-placement="top" aria-label="Ingresar Correo Correcto"
                                    data-bs-original-title="Ingresar Correo Existente"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-outline-secondary me-sm-3 me-1" data-bs-toggle="modal"
                            data-bs-target="#twoFactorAuth"><i class="mdi mdi-arrow-left me-1 scaleX-n1-rtl"></i><span
                                class="align-middle d-none d-sm-inline-block">Cerrar</span></button>
                        <button type="button" class="btn btn-primary" id="sendMail"><span
                                class="align-middle d-none d-sm-inline-block">Enviar</span><i
                                class="mdi mdi-arrow-right ms-1 scaleX-n1-rtl"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/css/pages/page-profile.css') }}">
    <style>
        .list-group-item {
            transition: opacity 0.3s ease, max-height 0.3s ease;
            max-height: 200px;
            /* Ajusta según sea necesario */
            overflow: hidden;
        }

        .list-group-item.hidden {
            opacity: 0;
            max-height: 0;
            padding-top: 0;
            padding-bottom: 0;
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
@endsection()

@section('scripts')
    <script>
        function downloadPDF(pdfUrl, name) {
            var link = document.createElement('a');
            link.href = pdfUrl;
            link.target = '_blank';
            link.download = name;

            document.body.appendChild(link);
            link.click();

            document.body.removeChild(link);
        }

        $(document).ready(function() {
            $('#referralLink').on('input', function() {
                var searchValue = $(this).val().toLowerCase().trim();

                $('#studentList .list-group-item').each(function() {
                    var studentName = $(this).find('.user-info h6').text().toLowerCase();
                    var studentCode = $(this).find('.user-status small').text().toLowerCase();

                    if (studentName.includes(searchValue) || studentCode.includes(searchValue)) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });
            });
        });



        const csrfToken = $('meta[name="csrf-token"]').attr("content");


        $("#sendMail").on("click", function() {
            blockUI();

            let formData = new FormData();
            const code = $("#codeStudent").val();
            formData.append("mail", $("#mailStudent").val());
            formData.append("code", code);
            formData.append("_token", csrfToken);

            $.ajax({
                    url: "mailStudent",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                })
                .done(function(response) {
                    Toast.fire({
                        icon: response.icon,
                        title: response.message,
                    });

                    $("#" + code).toggleClass('btn-primary btn-success');

                })
                .fail(function(xhr, status, error) {
                    console.error(xhr.responseText);
                })
                .always(function() {
                    $("#modalMail").modal('hide');
                    $("#codeStudent").val('');
                    $("#mailStudent").val('')
                    $("#student").text('');
                    $.unblockUI();
                });
        });

        function openModal(code, name, email) {
            $("#codeStudent").val(code);
            $("#student").text(`${name} (${code})`);
            $("#mailStudent").val(email);
            $("#modalMail").modal('show');
        }

        function blockUI() {
            $.blockUI({
                message: '<div class="d-flex justify-content-center"><p class="mt-1">Enviando Correo &nbsp; </p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
                css: {
                    backgroundColor: "transparent",
                    color: "#fff",
                    border: "0",
                },
                overlayCSS: {
                    opacity: 0.5
                },
            });
        }

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });
    </script>
@endsection
