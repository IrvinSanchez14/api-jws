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
  include_once '../objects/lista_producto_porcion.php';


  $database = new Database();
  $db = $database->getConnection();
  $lista = new lista_producto_porcion($db);
  $data = json_decode(file_get_contents("php://input"));

  if (empty($data->NombreProducto)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {
    $lista->IdProducto = $data->NombreProducto;
    $lista->IdPorcion = $data->Porcion;
    $lista->Estado = "0";
    $lista->UsuarioCreador = $data->UsuarioCreador;

    if ($lista->create()) {
      http_response_code(200);
      $last_id = $db->lastInsertId();
      echo json_encode(array("message" => $last_id));
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
