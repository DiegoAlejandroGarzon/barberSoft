<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUPON</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: beige;
            text-align: center;
            font-size: 9px; /* Reducción del tamaño de fuente */
        }
        .content {
            width: 100%;
            padding: 10px; /* Menor padding para ajustar el contenido */
        }
        .card {
            margin: 0 auto;
            width: 100%;
            max-width: 800px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 10px; /* Agregado padding interno */
        }
        .header, .footer {
            background-color: #008083;
            color: white;
            padding: 5px; /* Menor padding */
        }
        .section {
            margin: 10px 0; /* Menor margen entre secciones */
        }
        h1, h2, h3 {
            margin: 5px 0; /* Menor margen en encabezados */
        }
        p {
            margin: 3px 0; /* Menor margen en párrafos */
        }
        .image-fit {
            width: 100%;
            max-width: 180px; /* Reducir el tamaño máximo de la imagen */
            height: auto;
            margin: 0 auto;
        }
        .qr-code {
            margin-top: 10px; /* Menor margen superior */
        }
        .status-alert {
            padding: 5px; /* Menor padding */
            border-radius: 5px;
            margin-top: 5px; /* Menor margen superior */
        }
        .bg-success { background-color: #28a745; color: white; }
        .bg-warning { background-color: #ffc107; color: black; }
        .bg-danger { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="content">
        <div class="card">
            <div class="header">
                <h1>CUPON DEL EVENTO: {{$coupon->event->name}}</h1>
            </div>
            <div class="header">
                <h2>CODIGO: {{$coupon->numeric_code}}</h2>
            </div>
            <div class="section">
                <img class="image-fit" src="{{ storage_path('app/public/'. $coupon->event->header_image_path) }}" alt="{{ $coupon->event->name }}">
                <h2>Información del evento</h2>
                <p><strong>Nombre:</strong> {{ $coupon->event->name }}</p>
                <p><strong>Fecha:</strong> {{ $coupon->event->event_date }}</p>
                <p><strong>Hora de Inicio:</strong> {{ $coupon->event->start_time }}</p>
                <p><strong>Ciudad:</strong> {{ $coupon->event->city->name ?? 'N/A' }}</p>
                <p><strong>Dirección:</strong> {{ $coupon->event->address }}</p>
            </div>

            <div class="section">
                <h2>Información del ticket</h2>
                @if($coupon?->ticketType)
                    <p><strong>Tipo de Ticket:</strong> {{ $coupon->ticketType->name ?? 'N/A' }}</p>
                    <ul>
                        @foreach ($coupon->ticketType->features as $feature)
                            <li>
                                <strong>{{ $feature->name }}:</strong>
                                <span>{{ $feature->consumable ? 'Consumible' : 'Acceso' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <div class="status-alert {{ $coupon->is_consumed ? 'bg-danger' : 'bg-success' }} text-white">
                    <h3>ESTADO DEL CUPON:</h3>
                    <p>{{ $coupon->is_consumed ? 'CONSUMIDO' : 'NO CONSUMIDO' }}</p>
                </div>
            </div>

            <div class="qr-code">
                @if($coupon->qrCode)
                    <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="image-fit">
                @else
                    <p>Este Cupon no tiene un código QR asociado.</p>
                @endif
            </div>
            <br>
            <div class="footer">
                <h3>Cupon Virtual</h3>
            </div>
        </div>
    </div>
</body>
</html>


