$(() => {
    $(document).ready(function () {
        $("#referralLink").on("input", function () {
            var searchValue = $(this).val().toLowerCase().trim();

            $("#studentList .list-group-item").each(function () {
                var studentName = $(this)
                    .find(".user-info h6")
                    .text()
                    .toLowerCase();
                var studentCode = $(this)
                    .find(".user-status small")
                    .text()
                    .toLowerCase();

                if (
                    studentName.includes(searchValue) ||
                    studentCode.includes(searchValue)
                ) {
                    $(this).removeClass("hidden");
                } else {
                    $(this).addClass("hidden");
                }
            });
        });
    });

    const csrfToken = $('meta[name="csrf-token"]').attr("content"),
        courseName = $("#courseName").val(),
        courseId = $("#courseId").val(),
        file1 = $("#file1").val(),
        file2 = $("#file2").val();

    var e,
        o = $(".datatables-review");
    o.length &&
        ((e = o.DataTable({
            columns: [
                { data: "code" },
                { data: "code" },
                { data: "dni" },
                { data: "names" },
                { data: "course" },
                { data: "score" },
                { data: "email" },
                { data: "link" },
                { data: " " },
            ],

            columnDefs: [
                {
                    className: "control",
                    searchable: !1,
                    orderable: !1,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (a, t, x, s) {
                        return "";
                    },
                },

                {
                    targets: 2,
                    render: function (a, t, x, s) {
                        return (
                            '<a href="app-ecommerce-order-details.html"><span>' +
                            a +
                            "</span></a>"
                        );
                    },
                },
                {
                    targets: 3,
                    responsivePriority: 1,
                    render: function (a, t, x, s) {
                        return (
                            '<div class="d-flex flex-column"><span class="text-heading fw-medium" > ' +
                            a +
                            "</span></div></div>"
                        );
                    },
                },
                {
                    targets: 4,
                    responsivePriority: 2,
                    render: function (a, t, x, s) {
                        return (
                            '<div class="d-flex flex-column"><span class="text-heading fw-medium" > ' +
                            a +
                            "</span></div></div>"
                        );
                    },
                },
                {
                    targets: 7,
                    className: "text-center",
                    render: function (a, t, x, s) {
                        return `<a href="${a} " target="_blank">${a}  </a>`;
                    },
                },

                {
                    targets: -1,
                    title: "Acciones",
                    searchable: !1,
                    orderable: !1,
                    className: "text-center",
                    render: function (e, t, a, s) {
                        return '<div><div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="javascript:;" class="dropdown-item">Editar</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Eliminar</a></div></div></div>';
                    },
                },
            ],
            order: [[1, "asc"]],
            dom: '<"card-header d-flex align-items-md-center flex-wrap"<"me-5 ms-n2"f><"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-end align-items-md-center justify-content-md-end pt-0 gap-3 flex-wrap"l<"review_filter"> <"mx-0 me-md-n3 mt-sm-0"B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            lengthMenu: [
                [-1, 10, 25, 50],
                ["Todos", 10, 25, 50],
            ],
            pageLength: -1,
            language: {
                sLengthMenu: "_MENU_",
                search: "",
                searchPlaceholder: "Buscar Alumno",
                sEmptyTable: "Ningún dato disponible en esta tabla",
            },
            buttons: [
                {
                    className:
                        "btn btn-primary me-3 waves-effect waves-light btn-import",
                    text: '<i class="mdi mdi-microsoft-excel fs-4 me-1"></i> <span class="d-none d-sm-inline-block">Importar</span>',
                    action: function () {
                        document.getElementById("excelFile").click();
                    },
                },
                {
                    className:
                        "btn btn-success me-3 waves-effect waves-light btn-insert",
                    text: '<i class="mdi mdi-content-save-check fs-4 me-1"></i> <span class="d-none d-sm-inline-block">Guardar</span>',
                },
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (e) {
                            return "Detalles de " + e.data().names;
                        },
                    }),
                    type: "column",
                    renderer: function (e, t, a) {
                        a = $.map(a, function (e, t) {
                            return "" !== e.title
                                ? '<tr data-dt-row="' +
                                      e.rowIndex +
                                      '" data-dt-column="' +
                                      e.columnIndex +
                                      '"><td>' +
                                      e.title +
                                      ":</td> <td>" +
                                      e.data +
                                      "</td></tr>"
                                : "";
                        }).join("");
                        return (
                            !!a &&
                            $('<table class="table"/><tbody />').append(a)
                        );
                    },
                },
            },
            initComplete: function () {},
        })),
        $(".dataTables_length").addClass("mt-0 mt-md-3")),
        $(".datatables-review tbody").on(
            "click",
            ".delete-record",
            function () {
                e.row($(this).parents("tr")).remove().draw();
            }
        ),
        setTimeout(() => {
            $(".dataTables_filter .form-control").removeClass(
                "form-control-sm"
            ),
                $(".dataTables_length .form-select").removeClass(
                    "form-select-sm"
                );
        }, 300);

    document
        .getElementById("excelFile")
        .addEventListener("change", function (event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function (i) {
                const data = new Uint8Array(i.target.result);
                const workbook = XLSX.read(data, { type: "array" });

                // primera hoja
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];

                // Convierte la hoja de trabajo a un array de objetos JSON
                const jsonData = XLSX.utils.sheet_to_json(worksheet, {
                    header: 1,
                });

                // Formato Objeto
                const headers = jsonData[0];
                const rows = jsonData.slice(1).map((row) => {
                    let rowData = {};
                    row.forEach((cell, index) => {
                        rowData[headers[index]] = cell;
                    });
                    return rowData;
                });

                rows.forEach((row) => {
                    let rowData = {
                        code: row.cod_certificado,
                        dni: row.dni,
                        names: row.nombre_alumno,
                        course: row.curso,
                        score: row.nota,
                        email: row.email,
                        link: row.link,
                        "": "",
                    };
                    e.row.add(rowData).draw();
                });
            };

            reader.readAsArrayBuffer(file);
        });

    $("#sendMail").on("click", function () {
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
            .done(function (response) {
                Toast.fire({
                    icon: response.icon,
                    title: response.message,
                });

                console.log(response);

                $("#" + code).toggleClass("btn-primary btn-success");
            })
            .fail(function (xhr, status, error) {
                console.error(xhr.responseText);
            })
            .always(function () {
                $("#modalMail").modal("hide");
                $("#codeStudent").val("");
                $("#mailStudent").val("");
                $("#student").text("");
                $.unblockUI();
            });
    });

    $("#newStudent").on("click", function () {
        $("#titleModal").text("Nuevo Estudiante");
        $("#modalStudent").modal("show");
    });

    $(".btnEditStudent").on("click", function () {
        $("#titleModal").text("Editar Estudiante");
        const idStudent = $(this).data("student");
        blockUI();

        $.ajax({
            url: "scopeStudent",
            type: "POST",
            data: { _token: csrfToken, idStudent: idStudent },
        })
            .done((data) => {
                console.log(data);

                $("#codeCourse").val(data.course_id);
                $("#nameCourse").val(data.course_student);
                $("#inputStudent").val(data.id_student);
                $("#codeForm").val(data.code_student);
                $("#nameForm").val(data.name_student);
                $("#cipForm").val(data.cip_student);
                $("#mailForm").val(data.email_student);
                $("#scoreForm").val(data.score_student);
                $("#linkForm").val(data.url_student);
            })
            .fail((xhr) => {
                console.error("Error:", xhr.responseText);
            })
            .always(() => {
                $.unblockUI();
            });

        $("#modalStudent").modal("show");
    });

    $("#modalStudent").on("hidden.bs.modal", function () {
        $("#formStudent")[0].reset();
        fv.resetForm(true);
    });

    const f = document.getElementById("formStudent"),
        urlMap = {
            "Editar Estudiante": "updateStudent",
            "Nuevo Estudiante": "newStudent",
        };

    const fv = FormValidation.formValidation(f, {
        fields: {
            codeForm: {
                validators: {
                    notEmpty: {
                        message: "Ingresar el codigo de curso (Estudiante)",
                    },
                },
            },
            nameForm: {
                validators: {
                    notEmpty: { message: "Ingresar Nombres y Apellidos" },
                },
            },
            cipForm: {
                validators: {
                    notEmpty: { message: "Ingresar CIP estudiante" },
                },
            },
            mailForm: {
                validators: {
                    notEmpty: {
                        message: "Ingresar Correo Electrónico Estudiante",
                    },
                    emailAddress: {
                        message:
                            "El valor ingresado no es una dirección de correo válida",
                    },
                },
            },
            scoreForm: {
                validators: {
                    notEmpty: { message: "Ingresar Nota Estudiante" },
                },
            },
            linkForm: {
                validators: {
                    notEmpty: { message: "Ingresar Enlace de Doc." },
                },
            },
        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: "is-valid",
                rowSelector: function (t, e) {
                    switch (e) {
                        case "formValidationName":
                        case "formValidationEmail":
                        case "formValidationPass":
                        case "formValidationConfirmPass":
                        case "formValidationFile":
                        case "formValidationDob":
                        case "formValidationSelect2":
                        case "formValidationLang":
                        case "formValidationTech":
                        case "formValidationHobbies":
                        case "formValidationBio":
                        case "formValidationGender":
                            return ".col-md-6";
                        case "formValidationPlan":
                            return ".col-xl-3";
                        case "formValidationSwitch":
                        case "formValidationCheckbox":
                            return ".col-12";
                        default:
                            return ".row";
                    }
                },
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus(),
        },
    });

    fv.on("core.form.valid", function () {
        const method = $("#titleModal").text();
        sendDataServe(urlMap[method]);
    });

    $(".btn-insert").on("click", function () {
        blockUI();
        const rows = e.rows().data().toArray();
        let name = $("#title").val();

        if (rows.length === 0) {
            $.unblockUI();
            Toast.fire({
                icon: "error",
                title: "Debe existir al menos un registro en la tabla",
            });
            return;
        }

        let formData = new FormData();

        formData.append("file1", $("#file1").val());
        formData.append("file2", $("#file2").val());
        formData.append("courseId", courseId);
        formData.append("rows", JSON.stringify(rows));

        formData.append("_token", csrfToken);

        $.ajax({
            url: "importStudents",
            method: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
        })
            .done(function (response) {
                Toast.fire({
                    icon: response.icon,
                    title: response.message,
                });
                setTimeout(function () {
                    location.reload();
                }, 2000);
            })
            .fail(function (xhr, status, error) {
                Toast.fire({
                    icon: error.icon,
                    title: error.message,
                });
                console.error(xhr.responseText);
            })
            .always(function () {
                $.unblockUI();
            });
    });

    function sendDataServe(url) {
        // Bloquea la interfaz de usuario mientras se realiza la solicitud.
        blockUI();

        // Crea un objeto FormData a partir del formulario 'f'.
        let formData = new FormData(f);
        formData.append("courseId", courseId);
        formData.append("courseName", courseName);
        formData.append("file1", file1);
        formData.append("file2", file2);

        // Realiza la solicitud fetch al servidor.
        fetch(url, {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error en la solicitud"); // Manejo de errores
                }
                return response.json();
            })
            .then((data) => {
                // Muestra una notificación con el ícono y el mensaje proporcionados por el servidor.
                Toast.fire({
                    icon: data.icon,
                    title: data.message,
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);

                // Oculta el modal de producto.
                $("#modalStudent").modal("hide");
            })
            .catch((error) => {
                console.error("Error:", error.message);
            })
            .finally(() => {
                // Desbloquea la interfaz de usuario.
                $.unblockUI();
            });
    }

    function blockUI() {
        $.blockUI({
            message:
                '<div class="d-flex justify-content-center"><p class="mt-1"></p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            css: {
                backgroundColor: "transparent",
                color: "#fff",
                border: "0",
            },
            overlayCSS: {
                opacity: 0.5,
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
});

function openModal(code, name, email) {
    $("#codeStudent").val(code);
    $("#student").text(`${name} (${code})`);
    $("#mailStudent").val(email);
    $("#modalMail").modal("show");
}
const downloadPDF = (pdfUrl, name) => {
    var link = document.createElement("a");
    link.href = pdfUrl;
    link.target = "_blank";
    link.download = name;

    document.body.appendChild(link);
    link.click();

    document.body.removeChild(link);
};
