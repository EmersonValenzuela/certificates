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

    /**
     * Envía datos al servidor mediante una solicitud POST.
     * @param {string} url - La URL del servidor al que se enviarán los datos.
     */
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

                setTimeout(function() {
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
