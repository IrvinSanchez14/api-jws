<?php
if ($_SERVER['REQUEST_METHOD'] == "PUT"  || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: PUT");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../../config/database.php';
  include_once '../objects/permisoUsuario.php';


  $database = new Database();
  $db = $database->getConnection();
  $Permisos = new PermisoUsuario($db);
  $data = json_decode(file_get_contents("php://input"));
  $state = 0;

  $Permisos->IdUsuario = $data->IdUsuario;

  if ($data->Estado == "false") {
    $state = 1;
  } else {
    $state = 0;
  }
  $Permisos->Estado = $state;

  if ($Permisos->changeState()) {
    http_response_code(200);
    echo json_encode(
      array("message" => "Datos guardados exitosamente en Permisos.")
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
