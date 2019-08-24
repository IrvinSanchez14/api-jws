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

  include_once '../../config/database.php';
  include_once '../objects/tipo_producto.php';


  $database = new Database();
  $db = $database->getConnection();
  $TipoProducto = new TipoProducto($db);
  $data = json_decode(file_get_contents("php://input"));

  if (empty($data->Nombre)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {
    $TipoProducto->NombreTP = $data->Nombre;

    if(!$TipoProducto->validateNtipo()){
    $TipoProducto->Nombre = $data->Nombre;
    $TipoProducto->Descripcion = $data->Descripcion;
    $TipoProducto->Estado = "0";
    $TipoProducto->UsuarioCreador = $data->UsuarioCreador;

    if ($TipoProducto->create()) {
      http_response_code(200);
      echo json_encode(
        array(
          "flag" => 0,
          "message" => "Datos guardados exitosamente en Tipo Producto."
          )
      );
    } else {
      http_response_code(200);
      echo json_encode(
        array(
          "flag" => 0,
          "message" => "No se guardaron correctamente los datos."
           )
      );
    }
  }
  else {
    http_response_code(200);
      echo json_encode(
        array(
          "flag" => 2,
          "message" => "El nombre del tipo de producto ya existe en la base de datos."
          )
      );
    }
  }
} else {
  http_response_code(404);
}
