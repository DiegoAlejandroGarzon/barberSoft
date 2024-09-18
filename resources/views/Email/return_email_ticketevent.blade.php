@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Notificacion</title>
    <style>

        .text{

            font-size: 12px;
            font-style: italic;
            justify-content: center;
            justify-items: center;
            text-align: center;
            word-break: normal;
            word-wrap:break-word;
        }
      
    </style>
@endsection

@section('subcontent')
<div>
    <H1 class="text">Gracias por su compora {{$meta['name']}}</H1>
</div>
<div>
    <h3 class="text">Tu ticket para el ingreso al evento {{$meta['title']}} fue enviado al correo registrado😉<h3>
    <p class="text">que lo disfrutes y espero servirle en futuras ocaciones 😉</p>
</div>
<div>
    <h5 class="text"><a href="{{route('eventAssistant.index', ['idEvent' => $meta['id']])}}" style="align-items:center">Regresar</a></h5>
</div>
@endsection


