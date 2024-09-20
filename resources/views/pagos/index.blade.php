<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=USD"></script>
</head>
<body>
    <div id="paypal-button-container"></div>
    
    <script>
       
       paypal.Buttons({
    // ...
    createOrder: function(data, actions) {
        return actions.order.create({
            application_context: {
                shipping_preference: "NO_SHIPPING"
            },
            payer: {
                email_address: '{{ $email }}',
                name: {
                    given_name: '{{ $firstName }}',
                    surname: '{{ $lastName }}'
                },
                address: {
                    country_code: "{{ $country->code }}"
                }
            },
            purchase_units: [{
                amount: {
                    value: {{ $solution->getAmountToPay() }}
                }
            }],
        });
    },
    // ...
})

</script>
</body>
</html>