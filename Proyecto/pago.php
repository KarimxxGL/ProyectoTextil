<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;


$lista_carrito=array();

if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql =  $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC); 
    }
}else{
    header("Location: index.php");
    exit;
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Textileria </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet"></link>
</head>
<body>

<header>
  
  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <strong>Telas Quialite</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

        <div class="collapse navbar-collapse" id="navbarHeader">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">Catalogo</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link active">Contacto</a>
                </li>

            </ul>
            <a href="carrito.php" class="btn btn-primary">
                Carrito <span id="num_cart" class="badge bd-secondary"> <?php echo $num_cart; ?></span>
            </a>
        </div>
    </div>
  </div>
</header>  

<main>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h4>Detalles de pago</h4>
                <div id="paypal-button-container"></div> 
            </div>    
            <div class="col-6">
        <div class="table-resposive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($lista_carrito == null){
                        echo '<tr><td colspan="5 class="text-center"><b>Lista vacia</b></td></tr>';
                    }else{
                        $total=0;
                        foreach($lista_carrito as $producto){
                            $_id=$producto['id'];
                            $nombre=$producto['nombre'];
                            $precio=$producto['precio'];
                            $descuento=$producto['descuento'];  
                            $cantidad=$producto['cantidad'];
                            $precio_desc=$precio - (($precio * $descuento) / 100);
                            $subtotal=$cantidad * $precio_desc;
                            $total+=$subtotal;
                    
                    ?>

                    <tr>
                        <td><?php echo $nombre; ?></td>
                        
                        <td>
                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,'.',',');?></div>
                        </td>
                        
                    </tr>
                    <?php } ?>
                    <tr>
                                <td colspan="2">
                                <p class="h3 text-end" id="total"> <?php echo MONEDA . number_format($total,2,'.',','); ?></p>
                                </td>
                            </tr>

                </tbody>
                    </div>                
            </div> 
        </div> 
         
                <?php } ?>    
            </table>
        </div>

        <?php
            if($lista_carrito != null){
        ?>

        </div>

        <?php } ?>
    
    </div> 
</main>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENTE_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>

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
                        value: <?php echo $total; ?>
                    }
                }]
            });
        },
        onApprove: function(data, actions){ 
            let URL = 'clases/captura.php'
            actions.order.capture().then(function(detalles){
                console.log(detalles);
                let url = 'clases/captura.php'
                return fetch(url, {
                    method: 'post',
                    headers:{
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        detalles: detalles
                        
                    })
                })/*.then(function(response){
                    window.location.href="completado.html";
                })*/
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