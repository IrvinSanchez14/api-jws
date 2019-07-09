<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../../config/database.php';
  include_once '../objects/tipo_producto.php';


  $database = new Database();
  $db = $database->getConnection();
  $TipoProducto = new TipoProducto($db);
  $data = json_decode(file_get_contents("php://input"));
  
  if (empty($data->IdTipoProducto)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {
    $TipoProducto->IdTipoProducto = $data->IdTipoProducto;
    $TipoProducto->Nombre = $data->Nombre;
    $TipoProducto->FechaCreacion = $data->FechaCreacion;
    $TipoProducto->Descripcion = $data->Descripcion;
    $TipoProducto->Estado = "0";

    if ($TipoProducto->create()) {
      http_response_code(200);
      echo json_encode(
        array("message" => "Datos guardados exitosamente en Tipo Producto.")
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
