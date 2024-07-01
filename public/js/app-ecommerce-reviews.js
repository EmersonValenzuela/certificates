"use strict";
!(function () {
    let e = document.getElementById("uploadedAvatar");
    const l = document.querySelector(".account-file-input");
    if (e) {
        const r = e.src;
        l.onchange = () => {
            l.files[0] && (e.src = window.URL.createObjectURL(l.files[0]));
        };
    }

    let a = document.getElementById("uploadedAvatar2");
    const b = document.querySelector(".account-file-input2");
    if (a) {
        const f = a.src;
        b.onchange = () => {
            b.files[0] && (a.src = window.URL.createObjectURL(b.files[0]));
        };
    }
})(),
    $(function () {
        let t,
            a,
            s,
            csrfToken = $('meta[name="csrf-token"]').attr("content");
        s = (
            isDarkStyle
                ? ((t = config.colors_dark.borderColor),
                  (a = config.colors_dark.bodyBg),
                  config.colors_dark)
                : ((t = config.colors.borderColor),
                  (a = config.colors.bodyBg),
                  config.colors)
        ).headingColor;
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
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (e) {
                                return "Detalles de " + e.data().product;
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

        $(".btn-generate").on("click", function () {
            blockUI();
            const rows = e.rows().data().toArray();
            let name = $("#title").val(),
                csrfToken = $('meta[name="csrf-token"]').attr("content");

            if (!name.trim()) {
                $.unblockUI();
                Toast.fire({
                    icon: "error",
                    title: "Debes ingresar un nombre para el grupo de certificados",
                });
                return;
            }

            if (rows.length === 0) {
                $.unblockUI();
                Toast.fire({
                    icon: "error",
                    title: "Debe existir al menos un registro en la tabla",
                });
                return;
            }

            let formData = new FormData();

            formData.append("file1", $("#upload")[0].files[0]);
            formData.append("file2", $("#upload2")[0].files[0]);
            formData.append("name", name);
            formData.append("rows", JSON.stringify(rows));

            formData.append("_token", csrfToken);

            $.ajax({
                url: "scopeData",
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

                    Swal.fire({
                        title: "<strong>PDFs Generados</strong>",
                        icon: "success",
                        html: "Puedes ir al curso y enviar correo a alumnos o seguir generando PDFs",
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: false,
                        confirmButtonText:
                            '<i class="mdi mdi mdi-page-next me-2"></i> Ir a Curso',
                        cancelButtonText:
                            "<i class='mdi mdi mdi-plus-box me-2'></i> Seguir Aqui",
                        customClass: {
                            confirmButton:
                                "btn btn-primary me-3 waves-effect waves-light",
                            cancelButton:
                                "btn btn-outline-warning waves-effect",
                        },
                        buttonsStyling: false,
                        allowOutsideClick: false, // Evita que el modal se cierre al hacer clic fuera de él
                        allowEscapeKey: false, // Evita que el modal se cierre al presionar la tecla Escape
                        preConfirm: () => {
                            window.location.href = "Curso/" + response.course;
                        },
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.cancel) {
                            location.reload();
                        }
                    });
                })
                .fail(function (xhr, status, error) {
                    Toast.fire({
                        icon: "error",
                        title: "Contactar con proveedor sistemas.",
                    });
                    console.error(xhr.responseText);
                })
                .always(function () {
                    $.unblockUI();
                });
        });

        function blockUI() {
            $.blockUI({
                message:
                    '<div class="d-flex justify-content-center"><p class="mt-1">GENERANDO PDFS &nbsp; </p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
                css: {
                    backgroundColor: "transparent",
                    color: "#fff",
                    border: "0",
                },
                overlayCSS: { opacity: 0.5 },
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
