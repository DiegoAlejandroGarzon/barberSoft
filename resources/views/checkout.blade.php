@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')

<link rel="stylesheet" href="{{url('css/paypal.css')}}">
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo"
            data-sdk-integration-source="developer-studio"
></script>
<script>
    paypal
    .Buttons({
        style: {
            shape: "rect",
            layout: "vertical",
            color: "gold",
            label: "paypal",
        },
        message: {
            amount: 100,
        } ,

        async createOrder() {
            try {
                const response = await fetch("/api/orders", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    // use the "body" param to optionally pass additional order information
                    // like product ids and quantities
                    body: JSON.stringify({
                        cart: [
                            {
                                id: productValue,
                                quantity: productValue,
                            },
                        ],
                    }),
                });

                const orderData = await response.json();

                if (orderData.id) {
                    return orderData.id;
                }
                const errorDetail = orderData?.details?.[0];
                const errorMessage = errorDetail
                    ? `${errorDetail.issue} ${errorDetail.description} (${orderData.debug_id})`
                    : JSON.stringify(orderData);

                throw new Error(errorMessage);
            } catch (error) {
                console.error(error);
                // resultMessage(`Could not initiate PayPal Checkout...<br><br>${error}`);
            }
        } ,

        async onApprove(data, actions) {
            try {
                const response = await fetch(
                    `/api/orders/${data.orderID}/capture`,
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                    }
                );

                const orderData = await response.json();
                // Three cases to handle:
                //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                //   (2) Other non-recoverable errors -> Show a failure message
                //   (3) Successful transaction -> Show confirmation or thank you message

                const errorDetail = orderData?.details?.[0];

                if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
                    // (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    // recoverable state, per
                    // https://developer.paypal.com/docs/checkout/standard/customize/handle-funding-failures/
                    return actions.restart();
                } else if (errorDetail) {
                    // (2) Other non-recoverable errors -> Show a failure message
                    throw new Error(
                        `${errorDetail.description} (${orderData.debug_id})`
                    );
                } else if (!orderData.purchase_units) {
                    throw new Error(JSON.stringify(orderData));
                } else {
                    // (3) Successful transaction -> Show confirmation or thank you message
                    // Or go to another URL:  actions.redirect('thank_you.html');
                    const transaction =
                        orderData?.purchase_units?.[0]?.payments
                            ?.captures?.[0] ||
                        orderData?.purchase_units?.[0]?.payments
                            ?.authorizations?.[0];
                    resultMessage(
                        `Transaction ${transaction.status}: ${transaction.id}<br>
          <br>See console for all available details`
                    );
                    console.log(
                        "Capture result",
                        orderData,
                        JSON.stringify(orderData, null, 2)
                    );
                }
            } catch (error) {
                console.error(error);
                resultMessage(
                    `Sorry, your transaction could not be processed...<br><br>${error}`
                );
            }
        } ,
    })
    .render("#paypal-button-container");


    function handletclick(btnRadio){
        productValue=btnRadio.value;
        document.getElementById('paypal-button-container').style.display='Block';

    }

    </script>


@endsection

@section('subcontent')
<p>Seleccione un Producto</p>
<input type="radio" id="producto_1" name="producto" onclick="handletclick(this)" value="producto_1">
<label for="producto_1">Producto 1=$1.00</label><br>
<input type="radio" id="producto_2" name="producto" onclick="handletclick(this)" value="producto_2">
<label for="producto_2">Producto 2=$2.00</label><br>
<input type="radio" id="producto_3" name="producto" onclick="handletclick(this)" value="producto_3">
<label for="producto_3">Producto 3=$3.00</label><br>
<div id="paypal-button-container"></div>
<p id="result-message"></p>
@endsection

