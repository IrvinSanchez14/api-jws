<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
  http_response_code(200);
  echo "You dont have the correct method";
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
  http_response_code(200);
  include_once '../../config/database.php';
  include_once '../objects/produccion.php';

  $database = new Database();
  $db = $database->getConnection();
  $produccion = new Produccion($db);
  $data = json_decode(file_get_contents("php://input"));


  $produccion->IdPC = $data->ID;
  $produccion->IdEstado = $data->Estado;;


  if ($produccion->changeStateProduccion()) {
    http_response_code(200);
    //$last_id = $db->lastInsertId();
    echo json_encode(
      array("message" => "Datos guardados exitosamente en factura.")
    );
  } else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create factura."));
  }
} else {
  http_response_code(404);
}
