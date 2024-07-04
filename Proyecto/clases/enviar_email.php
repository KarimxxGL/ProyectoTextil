<?php 

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require '../phpmailer/PHPMailer/src/PHPMailer.php';
require '../phpmailer/PHPMailer/src/SMTP.php';
require '../phpmailer/PHPMailer/src/Exception.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //SMTP:: DEBUG_OFF;                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'arturokarim7819@gmail.com';                     //SMTP username
    $mail->Password   = 'Arturo7819';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //use 587 o  465 `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('arturokarim7819@gmail.com', 'Tienda');
    $mail->addAddress('arturokarim39@gmail.com', 'Joe User');     //Add a recipient              //Name is optional

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Detalles de la compra';

    $cuerpo = '<h4> Gracias por su compra </h4>';
    $cuerpo .= '<p> El ID de su compra es <b>' . $id_transaccion . '</b></p>';

    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de la compra.';

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();
} catch (Exception $e) {
    echo "Error al enviar correo. {$mail->ErrorInfo}";
    //exit;//
}
 

?>
