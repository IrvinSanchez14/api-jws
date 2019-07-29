<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../../config/database.php';
  include_once '../objects/permisos.php';


  $database = new Database();
  $db = $database->getConnection();
  $Permiso = new Permiso($db);
  $data = json_decode(file_get_contents("php://input"));

  if (empty($data->Nombre)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {
    $Permiso->Nombre = $data->Nombre;
    $Permiso->Descripcion = $data->Descripcion;
    $Permiso->Estado = "0";
    $Permiso->UsuarioCreador = $data->UsuarioCreador;


    if ($Permiso->create()) {
      http_response_code(200);
      echo json_encode(
        array("message" => "Datos guardados exitosamente en Permiso.")
      );
    } else {
      http_response_code(404);
      echo json_encode(
        array("message" => "No se guardaron correctamente los datos.")
      );
    }
  }
} else {
  http_response_code(404);
}
