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
  include_once '../objects/empresa.php';

  $database = new Database();
  $db = $database->getConnection();
  $empresa = new Empresas($db);
  $data = json_decode(file_get_contents("php://input"));


  $empresa->IdEmpresa = $data->IdEmpresa;

  echo json_encode($data);

  if ($data->Estado == "false") {
    $state = 1;
  } else {
    $state = 0;
  }
  $empresa->Estado = $state;

  echo json_encode($state);

  if ($empresa->changeState()) {
    http_response_code(200);
    //$last_id = $db->lastInsertId();
    echo json_encode(
      array("message" => "Datos guardados exitosamente en tipoUSuario.")
    );
  } else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create Empresa."));
  }
} else {
  http_response_code(404);
}
