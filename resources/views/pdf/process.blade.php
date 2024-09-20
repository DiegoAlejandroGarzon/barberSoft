<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=USD"></script>
    <script>
        paypal.Buttons({
     createOrder: function(data, actions) {
         return actions.order.create({
             // ...
          
             purchase_units: [{
                 amount: {
                 value: '100'
                 }
             }]
         });
     },
     onApprove: function(data, actions) {
         // ...
     }
    }).render('#paypal-button-container');
     </script>
</head>
<body>
    <div id="paypal-button-container"></div>
</body>
</html>

