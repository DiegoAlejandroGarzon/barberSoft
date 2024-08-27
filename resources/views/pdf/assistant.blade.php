<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF del Asistente</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <h1>{{ $evento->name }}</h1>
    <p><strong>Fecha del evento:</strong> {{ $evento->event_date }}</p>
    <hr>
    <h2>Información del Asistente</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <td>{{ $asistente->user->name }}</td>
        </tr>
        <tr>
            <th>Correo</th>
            <td>{{ $asistente->user->email }}</td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>{{ $asistente->user->phone }}</td>
        </tr>
        <tr>
            <th>Tipo de Ticket</th>
            <td>{{ $asistente->ticketType?->name }}</td>
        </tr>
        <tr>
            <th>Estado de Entrada</th>
            <td>{{ $asistente->has_entered ? 'Entrada' : 'No Entrada' }}</td>
        </tr>
    </table>
    <br>
    <div class="mt-4">
        <img src="{{ $qrCodeBase64 }}" alt="QR Code">
    </div>
</body>
</html>
