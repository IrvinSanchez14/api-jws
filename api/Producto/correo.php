<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../objects/produccion.php';
//include_once '/var/www/html/api-jws/api/objects/user.php';
//include_once '/var/www/html/api-jws/api/objects/produccion.php';
http_response_code(200);
$database = new Database();
$db = $database->getConnection();
//$user = new User($db);
$produccion = new Produccion($db);
$stmt = $produccion->productoVencido();
$num = $stmt->rowCount();

$asunto = 'Lista de productos Vencidos';
$cuerpo = '<div>';
if ($num > 0) {
  echo $num;
  $cuerpo .= '<table border="0.5"  ><tr style=" background-color: #4CAF50; color: white;"><th align="center">Fecha de Vencimiento</th><th align="center">Nombre</th><th align="center">Cantidad</th></tr>';
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $cuerpo .= '<tr><td align="center">' . $FechaVencimiento . '</td><td align="center">' . $Nombre . '</td><td align="center">' . $Numero_porciones . '</td></tr>';
  }
  $cuerpo .= "</table>";
}
$cuerpo .= '</div>';
if ($produccion->enviarEmail($asunto, $cuerpo)) {
  echo json_encode(
    array(
      "flag" => 0,
      "message" => "Correo enviado exitosamente.",
      //"url" => $url,
    ),
    JSON_UNESCAPED_SLASHES
  );
} else {
  http_response_code(400);
  echo json_encode(
    array(
      "flag" => 1,
      "Error" => "Problema al momento de enviar el Email, por favor intentelo mas tarde"
    )
  );
}
