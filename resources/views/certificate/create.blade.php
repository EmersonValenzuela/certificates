@extends('layouts/layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Certificado / </span> Generar
        </h4>

        <div class="row mb-4 g-4">
            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="mb-1">IMG Plantillas</h5>
                        <p class="mb-4"></p>
                        <div class="d-flex flex-column flex-sm-row justify-content-between text-center gap-3">
                            <div class="d-flex flex-column align-items-center">
                                <img src="{{ asset('img/avatars/1.png') }}" alt="user-avatar"
                                    class="d-block w-px-120 h-px-120 rounded mb-3" id="uploadedAvatar">
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span class="d-none d-sm-block">Subir Hoja 1</span>
                                        <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" hidden=""
                                            accept="image/png, image/jpeg">
                                    </label>
                                    <div class="small">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <img src="{{ asset('img/avatars/1.png') }}" alt="user-avatar"
                                    class="d-block w-px-120 h-px-120 rounded mb-3" id="uploadedAvatar2">
                                <div class="button-wrapper">
                                    <label for="upload2" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span class="d-none d-sm-block">Subir Hoja 2</span>
                                        <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                        <input type="file" id="upload2" class="account-file-input2" hidden=""
                                            accept="image/png, image/jpeg">
                                    </label>
                                    <div class="small">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-4 mt-1">
                            <h5>Datos de Curso</h5>
                            <div class="row g-2">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-book-account-outline fs-3"></i></span>
                                        <div class="form-floating form-floating-outline">

                                            <input type="text" id="title" name="title" class="form-control"
                                                placeholder="Ingresa titulo de curso">
                                            <label class="mb-0" for="title">Ingresa titulo de curso</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-3">
                                    <div class="row g-2">
                                        <div class="col-sm-9 col-lg-8">
                                            <button type="button"
                                                class="btn btn-primary  waves-effect waves-light btn-generate">
                                                Generar <i class="mdi mdi-file-pdf-box fs-3"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="file" id="excelFile" style="display: none;" accept=".xlsx, .xls">
        <!-- Referral List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="datatables-review table">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th>Codigo</th>
                            <th class="text-nowrap">DNI</th>
                            <th class="text-nowrap">Nombres</th>
                            <th>Curso</th>
                            <th>Nota</th>
                            <th>Email</th>
                            <th>Enlace</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection()

@section('styles')
@endsection()

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="{{ asset('js/app-ecommerce-reviews.js') }}"></script>
@endsection
