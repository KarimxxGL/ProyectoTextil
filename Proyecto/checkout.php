<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <script src="https://www.paypal.com/sdk/js?client-id=Ae3Jlxm902EIZ6xw3C4TFkbbAFtREn0nv8T0p8udEGSL4zKnmlw9esC6zmR5UN21-8SpFvV4yg0YI3ZM&currency=MXN">

    </script>
</head>
<body>
   <div id="paypal-button-container"></div> 
   <script>
    paypal.Buttons({
        style:{
            color: 'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions){
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: 100
                    }
                }]
            });
        },
        onApprove: function(data, actions){ 
            actions.order.capture().then(function(detalles){
                console.log(detalles);
                window.location.href="completado.html"
            });
        },
        onCancel: function(data){
            alert("Pago Cancelado")
            console.log(data);
        },
    }).render('#paypal-button-container');
   </script>
</body>

</html>