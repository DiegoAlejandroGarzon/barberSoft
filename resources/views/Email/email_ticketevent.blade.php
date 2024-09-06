<!doctype html>
<html lang="en">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        p {
            font-size: 12px;
        }

        .signature {
            font-style: italic;
        }
    </style>
</head>
<body>
<div>
    
    <p>Hey {{ $user->name }},</p>
    <p>Para el Evento  {{ $event->name }},</p>
    <p>Tu ticket fue enviado yet? 😉 </p>
    <p class="signature">Mailtrap</p>
    <div class="Footer"></div>
</div>
</body>
</html>