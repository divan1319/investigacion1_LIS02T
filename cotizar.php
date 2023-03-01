<?php
session_start();
$data = simplexml_load_file('productos.xml');

date_default_timezone_set('America/Mexico_City');

$fechaActual = date("d-m-Y");
$horaActual = date("h:i:s");

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cotizacion</title>
</head>
<body class="cont">
 <label type="text" class="date">Fecha de cotización: <?php echo $fechaActual ?></label>
    <table style="
    font-family: 'Lucida Sans Unicode', 'Lucida Grande', Sans-Serif;
    font-size: 12px;
    width: 100%;
    text-align: left;
    border-collapse: collapse;
  ">
<caption class="tit"> <h1>Cotización de productos</h1> <br></caption>

<thead>
   
  <tr>
    <th style="
          font-size: 13px;
          font-weight: normal;
          
          background: #b9c9fe;
          border-top: 4px solid #aabcfe;
          border-bottom: 1px solid #fff;
          color: #039;
        ">
      Producto
    </th>
    <th style="
          font-size: 13px;
          font-weight: normal;
          
          background: #b9c9fe;
          border-top: 4px solid #aabcfe;
          border-bottom: 1px solid #fff;
          color: #039;
        ">
      Cantidad
    </th>
    <th style="
          font-size: 13px;
          font-weight: normal;
          padding: 8px;
          background: #b9c9fe;
          border-top: 4px solid #aabcfe;
          border-bottom: 1px solid #fff;
          color: #039;
        ">
      Precio Unitario
    </th>
    <th style="
          font-size: 13px;
          font-weight: normal;
          padding: 8px;
          background: #b9c9fe;
          border-top: 4px solid #aabcfe;
          border-bottom: 1px solid #fff;
          color: #039;
        ">
      Total
    </th>
  </tr>
</thead>
<tbody>
<?php
      foreach ($_SESSION['cart'] as $productos => $quanti) {
        foreach ($data as $produc) {
          if ($productos == $produc->nombre) {
            ?>
        <tr class="line">
          <td style="
                      padding: 8px;
                      background: #e8edff;
                      border-bottom: 1px solid #fff;
                      color: #669;
                      border-top: 1px solid transparent;
                      
                    ">
                    <?= $productos ?>
          </td>
          <td style="
                      padding: 8px;
                      background: #e8edff;
                      border-bottom: 1px solid #fff;
                      color: #669;
                      border-top: 1px solid transparent;
                    ">
           <?= $quanti ?>
          </td>
          <td style="
                      padding: 8px;
                      background: #e8edff;
                      border-bottom: 1px solid #fff;
                      color: #669;
                      border-top: 1px solid transparent;
                    ">
                    <?= $produc->precio ?>
                     </td>
          <td style="
                      padding: 8px;
                      background: #e8edff;
                      border-bottom: 1px solid #fff;
                      color: #669;
                      border-top: 1px solid transparent;
                    ">
           <?= $quanti * $produc->precio; ?>
          </td>
        </tr>
        <?php
          }
        }
      } ?>
</tbody>
</table>
    
</body>
</html>
<?php
$html = ob_get_clean();
//reference PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// reference the Dompdf namespace
use Dompdf\Dompdf;

/////import PHPMailer libraries 
require 'library/PHPMailer/src/Exception.php';
require 'library/PHPMailer/src/PHPMailer.php';
require 'library/PHPMailer/src/SMTP.php';
require('library/dompdf/autoload.inc.php');

///recibiendo correo
$correo = $_POST['correo'];
////regex direccion de correo
$regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
////validando direccion de correo
if (preg_match($regex, $correo)) {

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Render the HTML as PDF
$dompdf->render();
//carpeta de donde se guardara el archivo pdf
$carpeta_destino = './cotizaciones/cotizacion_' . $correo . '.pdf';

  if (file_put_contents($carpeta_destino, $dompdf->output())) {

    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->isSMTP(); //Send using SMTP
      $mail->Host = 'smtp.office365.com'; //Set the SMTP server to send through
      $mail->SMTPAuth = true; //Enable SMTP authentication
      $mail->Username = 'pruebasejemplos@outlook.es'; //SMTP username
      $mail->Password = 'Pruebas.ejemplo23'; //SMTP password
      $mail->SMTPSecure = 'tls'; //Enable implicit TLS encryption
      $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom('pruebasejemplos@outlook.es', 'MiTienda');
      $mail->addAddress($correo); //Add a recipient

      //Content
      $mail->isHTML(true); //Set email format to HTML
      $mail->Subject = 'Cotizacion De Producto';
      $mail->Body = 'Gracias por preferirnos, se ha adjuntado la cotizacion para su respectiva revision.';

      //Attachments
      $mail->addAttachment('./cotizaciones/cotizacion_' . $correo . '.pdf', 'cotizacion.pdf'); //Add attachments


      $mail->send();
      session_destroy();
      echo "<script>alert('Se ha enviado un correo con la cotizacion de sus productos');
      window.location = 'http://pruebaejemplos.000webhostapp.com/investigacion/'
      </script>";
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  } else {
    echo "Al parecer hubo un error para generar el pdf";
  }
}else{
  echo "Direccion de correo electronico invalida";
}

?>