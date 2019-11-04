<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
  http_response_code(200);
  echo "You dont have the correct method";
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  http_response_code(200);
  include_once '../../config/database.php';
  include_once '../objects/produccion.php';


  $database = new Database();
  $db = $database->getConnection();
  $produccion = new Produccion($db);
  $data = json_decode(file_get_contents("php://input"));

  if (empty($data->Cabecera->lote)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {

    $produccion->lote = $data->Cabecera->lote;
    $produccion->IdCP = $data->Cabecera->IdCP;
    /*$produccion->Fechaproduccion = date("Y-m-d", strtotime($data->Cabecera->Fecha));
    $produccion->FechaIngreso = date("Y-m-d", strtotime($data->Cabecera->Fecha));*/
    $produccion->UsuarioCreador = $data->Cabecera->UsuarioCreador;

    if ($produccion->createCabecera()) {
      $last_id = $db->lastInsertId();
      if ($last_id > 0) {
        if ($produccion->createDetalle($last_id, $data->Detalle)) {
          http_response_code(200);
          echo json_encode(
            array("message" => "Datos guardados exitosamente")
          );
        }
      }
    } else {
      http_response_code(200);
      echo json_encode(
        array(
          "flag" => 1,
          "message" => "No se guardaron correctamente los datos."
        )
      );
    }
  }
} else {
  http_response_code(404);
}
