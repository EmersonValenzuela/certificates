<!-- resources/views/pdfs/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de PDFs</title>
</head>
<body>
    <h1>Lista de PDFs</h1>
    <ul>
        @foreach($pdfFiles as $file)
            <li>
                <a href="{{ asset('pdfs/' . basename($file)) }}" target="_blank">{{ basename($file) }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
