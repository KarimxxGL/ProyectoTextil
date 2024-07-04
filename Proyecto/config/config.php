<?php
    define("CLIENTE_ID", "Ae3Jlxm902EIZ6xw3C4TFkbbAFtREn0nv8T0p8udEGSL4zKnmlw9esC6zmR5UN21-8SpFvV4yg0YI3ZM");
    define("CURRENCY", "MXN");
    define("KEY_TOKEN", "DragonBall7");
    define("MONEDA", "$");

    session_start();

    $num_cart = 0;
    if(isset($_SESSION['carrito']['productos'])){
        $num_cart = count($_SESSION['carrito']['productos']);
    }
?>