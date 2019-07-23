<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  http_response_code(200);
  echo "You dont have the correct method";
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
  http_response_code(200);
  include_once '../../config/database.php';
  include_once '../objects/unidad_medida.php';


  $database = new Database();
  $db = $database->getConnection();
  $UnidadMedida = new UnidadMedida($db);
  $data = json_decode(file_get_contents("php://input"));
  $state = 0;

  $UnidadMedida->IdUnidadMedida = $data->IdUnidadMedida;

  if ($data->Estado == "false") {
    $state = 1;
  } else {
    $state = 0;
  }
  $UnidadMedida->Estado = $state;

  if ($UnidadMedida->changeState()) {
    http_response_code(200);
    echo json_encode(
      array("message" => "Datos guardados exitosamente en UnidadMedida.")
    );
  } else {
    http_response_code(404);
    echo json_encode(
      array("message" => "No se guardaron correctamente los datos.")
    );
  }
} else {
  http_response_code(404);
}
