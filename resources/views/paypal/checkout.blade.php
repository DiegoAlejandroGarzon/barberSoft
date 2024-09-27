@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')

<link rel="stylesheet" href="{{url('css/paypal.css')}}">
<script src="https://www.paypal.com/sdk/js?client-id=AePvnYTClaeHx9gxJIxBHqVDDCYleUjz6qTqG7M9MBCWo9hQE4zEBpJpHxuQ-IDWCk9kPKApEtkjiwTK&buyer-country=CO&currency=USD&components=buttons&enable-funding=venmo"
            data-sdk-integration-source="developer-studio"
></script>

<script src="{{url('js/paypal.js')}}"></script>


@endsection

@section('subcontent')


<x-base.form-input  type="hidden" id="event_assistant_id" name="event_assistant_id" value="{{ old('event_assistant_id', $pago['event_assistant_id']) }}"></x-base.form-input>

<x-base.form-label for="nombres">Nombre del Pagador:</x-base.form-label>
<x-base.form-input  type="text" id="nombres" name="nombres" value="{{ old('payer_name', $pago['payer_name']) }}"></x-base.form-input>

<x-base.form-input type="hidden" id="apellidos" name="apellidos"></x-base.form-input>


<x-base.form-label for="cedula">cedula:</x-base.form-label>
<x-base.form-input type="text" id="cedula" name="cedula" value="{{ old('payer_document_number', $pago['payer_document_number']) }}"></x-base.form-input>


<x-base.form-label for="amount">Monto a Pagar(USD):</x-base.form-label>
<x-base.form-input type="text" id="amount" name="amount" value="{{ old('->amount', $pago['amount']) }}"></x-base.form-input>

<x-base.form-label for="telefono">Celular:</x-base.form-label>
<x-base.form-input type="text" id="telefono" name="telefono" value=""></x-base.form-input>

<x-base.form-label for="producto">Seleccione un Producto</x-base.form-label><br>

<input type="radio" id="{{ $pago['evento'] }}" name="{{ $pago['evento'] }}" onclick="handletclick(this)" value="{{ $pago['evento'] }}">
<label for="{{ $pago['evento'] }}">{{ $pago['evento'] }}</label><br>


<div id="paypal-button-container"></div>
<p id="result-message"></p>
@endsection


