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
  include_once '../objects/user.php';

  $database = new Database();
  $db = $database->getConnection();
  $user = new User($db);
  $data = json_decode(file_get_contents("php://input"));


  $user->IdUsuario = $data->IdUsuario;
  $user->Nombre = $data->Nombre;
  $user->Email = $data->Email;
  $user->Alias = $data->Alias;
  $user->IdTipoUsuario = $data->valueSelect;
  $user->UsuarioActualiza = $data->UsuarioActualiza;



  if ($user->update()) {
    if ($data->valueSelectSucursal > 0) {
      $user->IdSucursal = $data->valueSelectSucursal;
      if ($user->updateUsuarioSucursal()) {
        http_response_code(200);
        echo json_encode(
          array("message" => "Datos guardados exitosamente en Empresa.")
        );
      }
    }
    http_response_code(200);
    echo json_encode(
      array("message" => "Datos guardados exitosamente en Empresa.")
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
