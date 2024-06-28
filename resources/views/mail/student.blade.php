<!-- view/mail/student.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Información del Estudiante</title>
    <style>
        /* Estilos opcionales para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Detalles del Estudiante</h2>
    <table>
        <tr>
            <th>Código del Estudiante</th>
            <td>{{ $student->code_student }}</td>
        </tr>
        <tr>
            <th>Nombre del Estudiante</th>
            <td>{{ $student->name_student }}</td>
        </tr>
        <tr>
            <th>Curso del Estudiante</th>
            <td>{{ $student->course_student }}</td>
        </tr>
        <!-- Agrega más filas según los datos que quieras mostrar -->
    </table>
</body>

</html>
