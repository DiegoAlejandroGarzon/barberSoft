@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')

<link rel="stylesheet" href="{{url('css/paypal.css')}}">
<script src="https://www.paypal.com/sdk/js?client-id=AePvnYTClaeHx9gxJIxBHqVDDCYleUjz6qTqG7M9MBCWo9hQE4zEBpJpHxuQ-IDWCk9kPKApEtkjiwTK&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo"
            data-sdk-integration-source="developer-studio"
></script>

<script src="{{url('js/paypal.js')}}"></script>


@endsection

@section('subcontent')

<x-base.form-label for="nombres">Nombres:{{env('PAYPAL_SANDBOX_CLIENT_ID')}}</x-base.form-label>

<x-base.form-input  type="text" id="nombres" name="nombres"></x-base.form-input>


<x-base.form-label for="nombres">Apellidos:</x-base.form-label>
<x-base.form-input type="text" id="apellidos" name="apellidos"></x-base.form-input>



<x-base.form-label for="cedula">cedula:</x-base.form-label>

<x-base.form-input type="text" id="cedula" name="cedula"></x-base.form-input>


<x-base.form-label for="telefono">telefono:</x-base.form-label>

<x-base.form-input type="text" id="telefono" name="telefono"></x-base.form-input>
<x-base.form-label for="producto">Seleccione un Producto</x-base.form-label><br>
<input type="radio" id="producto_1" name="producto" onclick="handletclick(this)" value="producto_1">
<label for="producto_1">Producto 1=$1.00</label><br>
<input type="radio" id="producto_2" name="producto" onclick="handletclick(this)" value="producto_2">
<label for="producto_2">Producto 2=$2.00</label><br>
<input type="radio" id="producto_3" name="producto" onclick="handletclick(this)" value="producto_3">
<label for="producto_3">Producto 3=$3.00</label><br>

<div id="paypal-button-container"></div>
<p id="result-message"></p>
@endsection


